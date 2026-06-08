<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF');

            DB::statement("CREATE TABLE demandes_new (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                entreprise_id INTEGER NOT NULL,
                travailleur_id INTEGER NOT NULL,
                apf_id INTEGER,
                type_allocation VARCHAR NOT NULL CHECK (type_allocation IN ('familiale', 'maternite', 'prenatale')),
                statut VARCHAR NOT NULL DEFAULT 'en_attente' CHECK (statut IN ('en_attente', 'validee', 'rejetee', 'liquidee')),
                documents TEXT,
                created_at DATETIME,
                updated_at DATETIME,
                FOREIGN KEY (entreprise_id) REFERENCES entreprises(id) ON DELETE CASCADE,
                FOREIGN KEY (travailleur_id) REFERENCES travailleurs(id) ON DELETE CASCADE,
                FOREIGN KEY (apf_id) REFERENCES apfs(id) ON DELETE SET NULL
            )");

            DB::statement('INSERT INTO demandes_new SELECT * FROM demandes');
            DB::statement('DROP TABLE demandes');
            DB::statement('ALTER TABLE demandes_new RENAME TO demandes');

            Schema::table('demandes', function (Blueprint $table) {
                $table->index('entreprise_id');
                $table->index('travailleur_id');
                $table->index('apf_id');
                $table->index('statut');
            });

            DB::statement('PRAGMA foreign_keys = ON');
        } else {
            DB::statement("ALTER TABLE demandes MODIFY COLUMN statut ENUM('en_attente', 'validee', 'rejetee', 'liquidee') NOT NULL DEFAULT 'en_attente'");
        }
    }

    public function down(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF');

            DB::statement("CREATE TABLE demandes_new (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                entreprise_id INTEGER NOT NULL,
                travailleur_id INTEGER NOT NULL,
                apf_id INTEGER,
                type_allocation VARCHAR NOT NULL CHECK (type_allocation IN ('familiale', 'maternite', 'prenatale')),
                statut VARCHAR NOT NULL DEFAULT 'en_attente' CHECK (statut IN ('en_attente', 'validee', 'rejetee')),
                documents TEXT,
                created_at DATETIME,
                updated_at DATETIME,
                FOREIGN KEY (entreprise_id) REFERENCES entreprises(id) ON DELETE CASCADE,
                FOREIGN KEY (travailleur_id) REFERENCES travailleurs(id) ON DELETE CASCADE,
                FOREIGN KEY (apf_id) REFERENCES apfs(id) ON DELETE SET NULL
            )");

            DB::statement("INSERT INTO demandes_new SELECT * FROM demandes WHERE statut != 'liquidee'");
            DB::statement('DROP TABLE demandes');
            DB::statement('ALTER TABLE demandes_new RENAME TO demandes');

            Schema::table('demandes', function (Blueprint $table) {
                $table->index('entreprise_id');
                $table->index('travailleur_id');
                $table->index('apf_id');
                $table->index('statut');
            });

            DB::statement('PRAGMA foreign_keys = ON');
        } else {
            DB::statement("ALTER TABLE demandes MODIFY COLUMN statut ENUM('en_attente', 'validee', 'rejetee') NOT NULL DEFAULT 'en_attente'");
        }
    }
};
