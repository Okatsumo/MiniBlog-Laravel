<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use function GuzzleHttp\Psr7\str;

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'=>Str::random(12),
            'content' =>'<div class="post__body post__body_full">
                          <div class="post__text post__text_v2" id="post-content-body"><p>18 марта пройдёт новый митап от Команды ВКонтакте — VK Tech Talks · Core Infrastructure. Приглашаем посмотреть трансляцию или обсудить доклады в закрытой онлайн-конференции. Интересно будет и там, и там!</p><figure class="full-width "><img src="https://habrastorage.org/getpro/habr/upload_files/9a6/1c4/6d0/9a61c46d097faf767d9fe7d4c519094c.png" width="780" height="440"><figcaption></figcaption></figure><p>С докладами о бэкенд-инфраструктуре выступят:&nbsp;</p><ul><li><p>Григорий Бутейко — «О бездонных бассейнах, или Как ограничить потребление памяти сервисами»;&nbsp;</p></li><li><p>Григорий Петросян — «Property-based тестирование»;&nbsp;</p></li><li><p>Илья Щербак — «„А что вы пишете на Go?“, или Чем занимается отдел инфраструктуры».&nbsp;</p></li></ul><p>Присоединяйтесь к видеовстрече, чтобы пообщаться с единомышленниками, задать вопросы спикерам и поучаствовать в тематической викторине с подарками для победителей. Заполните анкету регистрации по ссылке:&nbsp;<a href="https://vk.com/app6013442_-147415323?form_id=22#form_id=22">vk.cc/bZwDbw</a>&nbsp;(нужна авторизация в VK). </p><p>В день митапа в сообществе <a href="https://vk.com/vkteam">Команды</a> мы проведём прямую трансляцию для всех желающих. В  эфире будем 18 марта с 18:00 по московскому времени. Запись выступлений обязательно сохраним. До встречи!</p></div>

                        </div>',
            'rating'=>rand(0, 10),
            'image'=>'default.png',
            'author_id'=>1,
            'category_id'=>rand(1, 2),
            'created_at'=>now(),
            'updated_at'=>now()
        ];
    }
}
