<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Rating;
use App\Models\Votes;
use Illuminate\Support\Facades\Validator;

class OtherApiController extends Controller
{
    public function updateRating(Article $article)
    {
        $rating = Rating::find($article->rating_id);

        $validator = Validator::make(\request()->all(), [
            'points'=> 'required|integer|max:5',
        ]);

        if ($validator->fails()) {
            return response([
                'status' => 422,
                'errors' => $validator->getMessageBag(),
            ], 422);
        }

        if ($vote = Votes::where(
            [
                ['user_id', '=', auth()->user()->user_id],
                ['article_id', '=', $article->article_id],
            ]
        )->first()
        ) {
            $rating->totalPoints -= $vote->point;
            $vote->point = \request()->get('points');
            $vote->update();
        } else {
            $vote = new Votes();
            $vote->user_id = auth()->user()->user_id;
            $vote->article_id = $article->article_id;
            $vote->point = \request()->get('points');
            $vote->save();

            $rating->NumberOfVotes += 1;
        }

        $rating->totalPoints += \request()->get('points');

        if ($rating->NumberOfVotes <= 1) {
            $rating->rating = $rating->totalPoints;
        } else {
            $rating->rating = $rating->totalPoints / $rating->NumberOfVotes;
        }
        $rating->update();

        return response([
            'status' => 200,
            'rating' => $rating,
        ], 200);
    }
}
