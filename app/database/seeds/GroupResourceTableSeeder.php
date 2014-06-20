<?php

class GroupResourceTableSeeder extends Seeder {

    public function run() {
        //DB::table('group_resource')->delete();
        // 1
        for ($i = 1; $i <= 45; $i++) {
            GroupResource::create(array(
                'group_id' => 1,
                'resource_id' => $i
            ));
        }
        for ($i = 1; $i <= 18; $i++) {
            GroupResource::create(array(
                'group_id' => 2,
                'resource_id' => $i
            ));
        }
    }

}