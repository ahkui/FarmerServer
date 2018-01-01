<?php

use Illuminate\Database\Seeder;
use App\GoogleMapsApi;

class GoogleApiKeys extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GoogleMapsApi::firstOrCreate(['apikey'=>'AIzaSyDgm1gQkdBGlmnW5sykYXwb3nb7Wvm5dcs','used_count'=>0]);
        GoogleMapsApi::firstOrCreate(['apikey'=>'AIzaSyBjOyLtGSbH1vT9buzIRwQlO1a1aCUsQKY','used_count'=>0]);
        GoogleMapsApi::firstOrCreate(['apikey'=>'AIzaSyALy7d7mp0Je2FUuqoY8KRuWklvSCZKkNI','used_count'=>0]);
        GoogleMapsApi::firstOrCreate(['apikey'=>'AIzaSyDOrOg4jcx5Ezee1gAPENP07q6yMyee5NE','used_count'=>0]);
        GoogleMapsApi::firstOrCreate(['apikey'=>'AIzaSyDPaDA8s1bsHQR-hErG3KXGUjPhkXGY-bA','used_count'=>0]);
        GoogleMapsApi::firstOrCreate(['apikey'=>'AIzaSyDyGlTg-C-zGuzemNhoQNkUjwI0M0Z6AZs','used_count'=>0]);
        GoogleMapsApi::firstOrCreate(['apikey'=>'AIzaSyD9RozyHiGlT4mAqT3YKubPKnE6vbOeFIY','used_count'=>0]);
        GoogleMapsApi::firstOrCreate(['apikey'=>'AIzaSyCiZiroQ0XncrM7_JvXuX0h5Y9hWsm2M_g','used_count'=>0]);
        GoogleMapsApi::firstOrCreate(['apikey'=>'AIzaSyC0DCb9Al1GIsN1J_O_Y6WkB66XThLX1xY','used_count'=>0]);
        GoogleMapsApi::firstOrCreate(['apikey'=>'AIzaSyBbZ4UuTOpxicHSZ2zmG0j-oVKTKObTmCk','used_count'=>0]);
        GoogleMapsApi::firstOrCreate(['apikey'=>'AIzaSyCqEKHXyD716WGc6djtoa8wtCjvjSMVYLQ','used_count'=>0]);
        GoogleMapsApi::firstOrCreate(['apikey'=>'AIzaSyDqnbboRzuAp5-egVelUDNoGzIOSbNBOn0','used_count'=>0]);
        GoogleMapsApi::firstOrCreate(['apikey'=>'AIzaSyCNvFL5lFav_RH_xL8pbHZc5u7yadFwCFI','used_count'=>0]);
        GoogleMapsApi::firstOrCreate(['apikey'=>'AIzaSyD2rtKrgVhyXtdlcUDmKdZiV6jG7a8WkJs','used_count'=>0]);
        GoogleMapsApi::firstOrCreate(['apikey'=>'AIzaSyB99aUCeJbS2rbGYK9cfT6v5x8Mktrn794','used_count'=>0]);
        GoogleMapsApi::firstOrCreate(['apikey'=>'AIzaSyDROzY17HbBAxqeiA1n_tFTDCnOtkGX6t8','used_count'=>0]);
    }
}
