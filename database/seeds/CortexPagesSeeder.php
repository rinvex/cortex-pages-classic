<?php

declare(strict_types=1);

use Illuminate\Database\Seeder;

class CortexPagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bouncer::allow('admin')->to('list', config('rinvex.pages.models.page'));
        Bouncer::allow('admin')->to('create', config('rinvex.pages.models.page'));
        Bouncer::allow('admin')->to('update', config('rinvex.pages.models.page'));
        Bouncer::allow('admin')->to('delete', config('rinvex.pages.models.page'));
        Bouncer::allow('admin')->to('audit', config('rinvex.pages.models.page'));
    }
}
