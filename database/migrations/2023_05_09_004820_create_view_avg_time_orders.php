<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
        CREATE OR REPLACE VIEW view_layanan_rekomendasi
        AS
        SELECT
    `q`.`category_id` AS `category_id`,
    `q`.`category_name` AS `category_name`,
    `q`.`nama_layanan` AS `nama_layanan`,
    `q`.`created_at` AS `created_at`,
    `q`.`TIMEDIFF` AS `TIMEDIFF`,
    `q`.`id` AS `id`,
    `q`.`services_id` AS `services_id`
FROM
    (
    SELECT
        `categories`.`id` AS `category_id`,
        `categories`.`name` AS `category_name`,
        `services`.`name` AS `nama_layanan`,
        MAX(
            `orders_sosmeds`.`created_at`
        ) AS `created_at`,
        TIME_TO_SEC(
            TIMEDIFF(
                MAX(
                    `orders_sosmeds`.`updated_at`
                ),
                MAX(
                    `orders_sosmeds`.`created_at`
                )
            )
        ) AS `TIMEDIFF`,
        MAX(
            `orders_sosmeds`.`id`
        ) AS `id`,
        `orders_sosmeds`.`service_id` AS `services_id`
    FROM
        (
            (
                `orders_sosmeds`
            JOIN `services` ON
                (
                    `services`.`id` = `orders_sosmeds`.`service_id`
                )
            )
        JOIN `categories` ON
            (
                `categories`.`id` = `services`.`category_id`
            )
        )
    WHERE
        `orders_sosmeds`.`status` = 'Success' AND `services`.`status` = 1
    GROUP BY
        `orders_sosmeds`.`service_name`
    ORDER BY
        TIME_TO_SEC(
            TIMEDIFF(
                MAX(
                    `orders_sosmeds`.`updated_at`
                ),
                MAX(
                    `orders_sosmeds`.`created_at`
                )
            )
        )
) `q`
ORDER BY
    `q`.`created_at`
DESC
    
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
