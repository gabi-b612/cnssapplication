<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const NEW_STATUTS = ['brouillon', 'soumise', 'en_verification', 'approuvee', 'payee', 'rejetee'];

    public function up(): void
    {
        Schema::table('demandes', function (Blueprint $table) {
            $table->text('motif_rejet')->nullable()->after('statut');
        });

        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'sqlite') {
            $this->recreateSqliteTable(self::NEW_STATUTS, 'soumise', true);
        } else {
            DB::statement('ALTER TABLE demandes MODIFY COLUMN statut VARCHAR(50) NOT NULL DEFAULT \'en_attente\'');

            DB::table('demandes')->where('statut', 'en_attente')->update(['statut' => 'en_verification']);
            DB::table('demandes')->where('statut', 'validee')->update(['statut' => 'approuvee']);
            DB::table('demandes')->where('statut', 'liquidee')->update(['statut' => 'payee']);

            $statutList = implode("', '", self::NEW_STATUTS);
            DB::statement("ALTER TABLE demandes MODIFY COLUMN statut ENUM('{$statutList}') NOT NULL DEFAULT 'soumise'");
        }
    }

    public function down(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'sqlite') {
            $this->recreateSqliteTable(['en_attente', 'validee', 'rejetee', 'liquidee'], 'en_attente', false);
        } else {
            DB::statement('ALTER TABLE demandes MODIFY COLUMN statut VARCHAR(50) NOT NULL DEFAULT \'soumise\'');

            DB::table('demandes')->where('statut', 'en_verification')->update(['statut' => 'en_attente']);
            DB::table('demandes')->where('statut', 'approuvee')->update(['statut' => 'validee']);
            DB::table('demandes')->where('statut', 'payee')->update(['statut' => 'liquidee']);
            DB::table('demandes')->whereIn('statut', ['brouillon', 'soumise'])->update(['statut' => 'en_attente']);

            DB::statement("ALTER TABLE demandes MODIFY COLUMN statut ENUM('en_attente', 'validee', 'rejetee', 'liquidee') NOT NULL DEFAULT 'en_attente'");
        }

        Schema::table('demandes', function (Blueprint $table) {
            $table->dropColumn('motif_rejet');
        });
    }

    private function recreateSqliteTable(array $statuts, string $default, bool $forward): void
    {
        DB::statement('PRAGMA foreign_keys = OFF');

        $checkConstraint = implode(', ', array_map(fn ($s) => "'{$s}'", $statuts));

        DB::statement("CREATE TABLE demandes_new (
            id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            entreprise_id INTEGER NOT NULL,
            travailleur_id INTEGER NOT NULL,
            apf_id INTEGER,
            type_allocation VARCHAR NOT NULL CHECK (type_allocation IN ('familiale', 'maternite', 'prenatale')),
            statut VARCHAR NOT NULL DEFAULT '{$default}' CHECK (statut IN ({$checkConstraint})),
            motif_rejet TEXT,
            documents TEXT,
            created_at DATETIME,
            updated_at DATETIME,
            FOREIGN KEY (entreprise_id) REFERENCES entreprises(id) ON DELETE CASCADE,
            FOREIGN KEY (travailleur_id) REFERENCES travailleurs(id) ON DELETE CASCADE,
            FOREIGN KEY (apf_id) REFERENCES apfs(id) ON DELETE SET NULL
        )");

        if ($forward) {
            DB::statement("INSERT INTO demandes_new (id, entreprise_id, travailleur_id, apf_id, type_allocation, statut, motif_rejet, documents, created_at, updated_at)
                SELECT id, entreprise_id, travailleur_id, apf_id, type_allocation,
                    CASE statut
                        WHEN 'en_attente' THEN 'en_verification'
                        WHEN 'validee' THEN 'approuvee'
                        WHEN 'liquidee' THEN 'payee'
                        ELSE statut
                    END,
                    motif_rejet, documents, created_at, updated_at
                FROM demandes");
        } else {
            DB::statement("INSERT INTO demandes_new (id, entreprise_id, travailleur_id, apf_id, type_allocation, statut, documents, created_at, updated_at)
                SELECT id, entreprise_id, travailleur_id, apf_id, type_allocation,
                    CASE statut
                        WHEN 'en_verification' THEN 'en_attente'
                        WHEN 'approuvee' THEN 'validee'
                        WHEN 'payee' THEN 'liquidee'
                        WHEN 'brouillon' THEN 'en_attente'
                        WHEN 'soumise' THEN 'en_attente'
                        ELSE statut
                    END,
                    documents, created_at, updated_at
                FROM demandes");
        }

        DB::statement('DROP TABLE demandes');
        DB::statement('ALTER TABLE demandes_new RENAME TO demandes');

        Schema::table('demandes', function (Blueprint $table) {
            $table->index('entreprise_id');
            $table->index('travailleur_id');
            $table->index('apf_id');
            $table->index('statut');
        });

        DB::statement('PRAGMA foreign_keys = ON');
    }
};
