<?php

namespace Database\Seeders;

use App\Models\Deck;
use App\Models\VocabWord;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Database\Seeder;

class DemoQuizSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo 1 deck demo HSK1 (idempotent theo slug)
        $deck = Deck::firstOrCreate(
            ['slug' => 'hsk1-greetings-basics'],
            [
                'user_id'     => null, // deck hệ thống
                'name'        => 'HSK 1 – Greetings & Basics',
                'level'       => 'HSK1',
                'language'    => 'zh',
                'description' => 'Các mẫu câu chào hỏi và cơ bản trong HSK 1.',
                'is_public'   => true,
            ]
        );

        // Danh sách từ vựng demo
        $wordsData = [
            [
                'term'                => '你好',
                'reading'             => 'nǐ hǎo',
                'meaning_vi'          => 'xin chào',
                'meaning_en'          => 'hello',
                'example_sentence'    => '你好！我是学生。',
                'example_translation' => 'Xin chào! Tôi là học sinh.',
                'question_prompt'     => 'Nghĩa tiếng Việt của "你好" là gì?',
                'options'             => [
                    ['text' => 'xin chào',     'correct' => true],
                    ['text' => 'tạm biệt',     'correct' => false],
                    ['text' => 'cảm ơn',       'correct' => false],
                    ['text' => 'xin lỗi',      'correct' => false],
                ],
            ],
            [
                'term'                => '谢谢',
                'reading'             => 'xièxie',
                'meaning_vi'          => 'cảm ơn',
                'meaning_en'          => 'thank you',
                'example_sentence'    => '谢谢你的帮助。',
                'example_translation' => 'Cảm ơn sự giúp đỡ của bạn.',
                'question_prompt'     => 'Nghĩa tiếng Việt của "谢谢" là gì?',
                'options'             => [
                    ['text' => 'xin lỗi',      'correct' => false],
                    ['text' => 'cảm ơn',       'correct' => true],
                    ['text' => 'tạm biệt',     'correct' => false],
                    ['text' => 'không có gì',  'correct' => false],
                ],
            ],
            [
                'term'                => '对不起',
                'reading'             => 'duìbuqǐ',
                'meaning_vi'          => 'xin lỗi',
                'meaning_en'          => 'sorry',
                'example_sentence'    => '对不起，我来晚了。',
                'example_translation' => 'Xin lỗi, tôi đến muộn.',
                'question_prompt'     => 'Nghĩa tiếng Việt của "对不起" là gì?',
                'options'             => [
                    ['text' => 'xin chào',     'correct' => false],
                    ['text' => 'tạm biệt',     'correct' => false],
                    ['text' => 'xin lỗi',      'correct' => true],
                    ['text' => 'cảm ơn',       'correct' => false],
                ],
            ],
        ];

        foreach ($wordsData as $wordData) {
            // Tạo vocab_word (idempotent theo deck + term)
            $word = VocabWord::firstOrCreate(
                [
                    'deck_id' => $deck->id,
                    'term'    => $wordData['term'],
                ],
                [
                    'reading'             => $wordData['reading'],
                    'meaning_vi'          => $wordData['meaning_vi'],
                    'meaning_en'          => $wordData['meaning_en'],
                    'example_sentence'    => $wordData['example_sentence'],
                    'example_translation' => $wordData['example_translation'],
                ]
            );

            // Mỗi lần seed lại, để chắc chắn không nhân đôi options,
            // ta xoá questions cũ của word này (nếu có) rồi tạo lại.
            $word->questions()->delete();

            $question = Question::create([
                'vocab_word_id' => $word->id,
                'type'          => 'multiple_choice',
                'prompt'        => $wordData['question_prompt'],
                'explanation'   => 'Ôn lại nghĩa cơ bản của từ vựng HSK 1.',
            ]);

            $order = 1;
            foreach ($wordData['options'] as $opt) {
                QuestionOption::create([
                    'question_id'   => $question->id,
                    'option_text'   => $opt['text'],
                    'is_correct'    => $opt['correct'],
                    'option_order'  => $order,
                ]);
                $order++;
            }
        }
    }
}
