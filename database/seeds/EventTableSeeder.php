<?php

use App\Models\Event;
use App\Models\Order;
use Faker\Factory;
use Illuminate\Database\Seeder;

class EventTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        factory(Event::class, 50)->create()->each(function ($event) use ($faker) {
            $event->image = 'https://picsum.photos/600/400/?random&dummyParam=' . $event->id;
            $event->save();

            for ($i = 1; $i <= $faker->numberBetween(1, 10); $i++) {
                $event->orders()->save(factory(Order::class)->make());
            }
        });
    }
}
