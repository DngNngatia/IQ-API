<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Topic::class, 3)->create();
        collect(\App\Topic::get())->each(function ($topic) {
            factory(\App\Subject::class, 5)->create(['topic_id' => $topic->id]);
        });
        collect(\App\Subject::get())->each(function ($subject) {
            factory(\App\Question::class, 20)->create(['subject_id' => $subject->id]);
        });
        collect(\App\Question::get())->each(function ($question) {
            factory(\App\Answer::class, 4)->create(['question_id' => $question->id]);
        });
    }
}
