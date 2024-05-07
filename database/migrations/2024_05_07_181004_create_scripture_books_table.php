<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('volume_id')
                ->constrained();
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('chapters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')
                ->constrained();
            $table->unsignedInteger('number');
            $table->timestamps();
        });

        Schema::create('chapter_come_follow_me', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chapter_id')
                ->constrained();
            $table->foreignId('come_follow_me_id')
                ->constrained();
            $table->timestamps();
        });
        $volumes = [
            'Old Testament' => [
                'Genesis' => 50,
                'Exodus' => 40,
                'Leviticus' => 27,
                'Numbers' => 36,
                'Deuteronomy' => 34,
                'Joshua' => 24,
                'Judges' => 21,
                'Ruth' => 4,
                '1 Samuel' => 31,
                '2 Samuel' => 24,
                '1 Kings' => 22,
                '2 Kings' => 25,
                '1 Chronicles' => 29,
                '2 Chronicles' => 36,
                'Ezra' => 10,
                'Nehemiah' => 13,
                'Esther' => 10,
                'Job' => 42,
                'Psalms' => 150,
                'Proverbs' => 31,
                'Ecclesiastes' => 12,
                'Song of Solomon' => 8,
                'Isaiah' => 66,
                'Jeremiah' => 52,
                'Lamentations' => 5,
                'Ezekiel' => 48,
                'Daniel' => 12,
                'Hosea' => 14,
                'Joel' => 3,
                'Amos' => 9,
                'Obadiah' => 1,
                'Jonah' => 4,
                'Micah' => 7,
                'Nahum' => 3,
                'Habakkuk' => 3,
                'Zephaniah' => 3,
                'Haggai' => 2,
                'Zechariah' => 14,
                'Malachi' => 4,
            ],
            'New Testament' => [
                'Matthew' => 28,
                'Mark' => 16,
                'Luke' => 24,
                'John' => 21,
                'Acts' => 28,
                'Romans' => 16,
                '1 Corinthians' => 16,
                '2 Corinthians' => 13,
                'Galatians' => 6,
                'Ephesians' => 6,
                'Philippians' => 4,
                'Colossians' => 4,
                '1 Thessalonians' => 5,
                '2 Thessalonians' => 3,
                '1 Timothy' => 6,
                '2 Timothy' => 4,
                'Titus' => 3,
                'Philemon' => 1,
                'Hebrews' => 13,
                'James' => 5,
                '1 Peter' => 5,
                '2 Peter' => 3,
                '1 John' => 5,
                '2 John' => 1,
                '3 John' => 1,
                'Jude' => 1,
                'Revelation' => 22,
            ],
            'Book of Mormon' => [
                '1 Nephi' => 22,
                '2 Nephi' => 33,
                'Jacob' => 7,
                'Enos' => 1,
                'Jarom' => 1,
                'Omni' => 1,
                'Words of Mormon' => 1,
                'Mosiah' => 29,
                'Alma' => 63,
                'Helaman' => 16,
                '3 Nephi' => 30,
                '4 Nephi' => 1,
                'Mormon' => 9,
                'Ether' => 15,
                'Moroni' => 10,
            ],
            'Doctrine and Covenants' => [
                'Section' => 138,
            ],
            //            'Pearl of Great Price' => [
            //                'Moses', 'Abraham', 'Joseph Smith — Matthew', 'Joseph Smith — History',
            //            ],
        ];

        foreach ($volumes as $volume => $books) {
            $volume = \App\Models\Scriptures\Volume::firstWhere(['name' => $volume]);
            foreach ($books as $book => $chapters) {
                $b = $volume->books()->create(['name' => $book]);
                foreach (range(1, $chapters) as $chapter) {
                    $b->chapters()->create(['number' => $chapter]);
                }
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('chapter_come_follow_me');
        Schema::dropIfExists('chapters');
        Schema::dropIfExists('books');
    }
};
