<?php

namespace Database\Seeders;

use App\Models\University;
use App\Models\UniversityComment;
use App\Models\User;
use Illuminate\Database\Seeder;

class UniversityCommentSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('is_admin', false)->get();

        if ($users->isEmpty()) {
            $this->command->warn('⚠️ مفيش يوزرز — شغّل UserSeeder أول');
            return;
        }

        $comments = [
            'جامعة القاهرة' => [
                [
                    'user'   => 'أحمد محمد',
                    'rating' => 5,
                    'body'   => 'جامعة القاهرة من أحسن الجامعات على الإطلاق، المستوى الأكاديمي ممتاز والأساتذة على مستوى عالي. الحرم الجامعي جميل جداً وفيه كل الخدمات.',
                    'replies' => [
                        ['user' => 'فاطمة علي', 'body' => 'كلام صح 100%، أنا في كلية التجارة وبشكر نفسي على الاختيار ده!'],
                        ['user' => 'محمد إبراهيم', 'body' => 'موافق، بس الزحمة في الحرم صعبة أحياناً 😅'],
                    ],
                ],
                [
                    'user'   => 'نورهان خالد',
                    'rating' => 4,
                    'body'   => 'تجربتي في كلية الحقوق كانت ممتازة، الأساتذة محترفون والمنهج شامل. بس الرسوم الدراسية كانت زيادة شوية.',
                    'replies' => [
                        ['user' => 'عمر حسن', 'body' => 'حقوق القاهرة من أحسن كليات الحقوق في مصر!'],
                    ],
                ],
            ],
            'جامعة أسيوط' => [
                [
                    'user'   => 'محمد إبراهيم',
                    'rating' => 5,
                    'body'   => 'جامعة أسيوط جامعة عظيمة، خصوصاً كلية الطب اللي من أحسن الكليات في مصر. الأساتذة متميزون والبيئة الدراسية هادئة.',
                    'replies' => [
                        ['user' => 'سارة أحمد', 'body' => 'طب أسيوط ليها سمعة ممتازة فعلاً!'],
                        ['user' => 'يوسف طارق', 'body' => 'وكمان الهندسة تمام، أنا خريج هندسة أسيوط 💪'],
                    ],
                ],
                [
                    'user'   => 'سارة أحمد',
                    'rating' => 4,
                    'body'   => 'من أحسن قرارات حياتي إني اتسجلت في جامعة أسيوط. الجو هادي، التكلفة معقولة، والمستوى أكاديمي ممتاز.',
                    'replies' => [
                        ['user' => 'أحمد محمد', 'body' => 'كلام صح، وأسعار السكن هناك حلوة برضو!'],
                    ],
                ],
            ],
            'جامعة الإسكندرية' => [
                [
                    'user'   => 'فاطمة علي',
                    'rating' => 5,
                    'body'   => 'جامعة الإسكندرية تجربة رائعة، مش بس عشان المستوى الأكاديمي العالي لكن كمان عشان مدينة الإسكندرية نفسها جميلة ومعيشتها حلوة.',
                    'replies' => [
                        ['user' => 'نورهان خالد', 'body' => 'إسكندرية أحلى مدينة في مصر! عايشة فيها 4 سنين وبحبها جداً 💙'],
                    ],
                ],
                [
                    'user'   => 'عمر حسن',
                    'rating' => 4,
                    'body'   => 'كلية التجارة في جامعة الإسكندرية ممتازة، الأساتذة محترفون والمنهج حديث ومتطور.',
                    'replies' => [],
                ],
            ],
            'جامعة المنصورة' => [
                [
                    'user'   => 'يوسف طارق',
                    'rating' => 5,
                    'body'   => 'جامعة المنصورة وخاصة كلية الطب من أفضل الكليات الطبية في مصر. الأساتذة على مستوى عالمي والتدريب العملي ممتاز.',
                    'replies' => [
                        ['user' => 'مريم سامي', 'body' => 'طب المنصورة شهرته وصلت لكل مصر! ❤️'],
                    ],
                ],
            ],
            'الجامعة الأمريكية بالقاهرة' => [
                [
                    'user'   => 'مريم سامي',
                    'rating' => 5,
                    'body'   => 'الجامعة الأمريكية تجربة لا تُنسى، المستوى الأكاديمي عالمي والبيئة الدراسية ممتازة. الرسوم مرتفعة لكن تستاهل.',
                    'replies' => [
                        ['user' => 'سارة أحمد', 'body' => 'بالتأكيد تستاهل! الشهادة منها بتفتح أبواب كتير!'],
                        ['user' => 'عمر حسن', 'body' => 'الرسوم مرتفعة جداً بصراحة، بس المستوى فعلاً مختلف تماماً.'],
                    ],
                ],
            ],
            'جامعة النيل' => [
                [
                    'user'   => 'أحمد محمد',
                    'rating' => 4,
                    'body'   => 'جامعة النيل متخصصة في التكنولوجيا والبحث العلمي، الأساتذة من نخبة الكفاءات. مناسبة جداً لمحبي الابتكار والتكنولوجيا.',
                    'replies' => [
                        ['user' => 'يوسف طارق', 'body' => 'سمعتها ممتازة في مجال الهندسة والتكنولوجيا!'],
                    ],
                ],
            ],
        ];

        $totalComments = 0;

        foreach ($comments as $universityName => $universityComments) {
            $university = University::where('name', $universityName)->first();

            if (!$university) continue;

            foreach ($universityComments as $commentData) {
                $user = $users->firstWhere('name', $commentData['user']);
                if (!$user) $user = $users->random();

                $comment = UniversityComment::create([
                    'university_id' => $university->id,
                    'user_id'       => $user->id,
                    'body'          => $commentData['body'],
                    'rating'        => $commentData['rating'],
                    'parent_id'     => null,
                    'is_approved'   => true,
                ]);

                $totalComments++;

                foreach ($commentData['replies'] as $replyData) {
                    $replyUser = $users->firstWhere('name', $replyData['user']);
                    if (!$replyUser) $replyUser = $users->random();

                    UniversityComment::create([
                        'university_id' => $university->id,
                        'user_id'       => $replyUser->id,
                        'parent_id'     => $comment->id,
                        'body'          => $replyData['body'],
                        'rating'        => null,
                        'is_approved'   => true,
                    ]);

                    $totalComments++;
                }
            }
        }

        $this->command->info("✅ تم إنشاء {$totalComments} تعليق ورد بنجاح");
    }
}
