<?php

namespace App\Http\Controllers;

use App\Models\ArticleNews;
use App\Models\Author;
use App\Models\BannerAdvertisement;
use App\Models\Category;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    //
    public function index(){
        $categories = Category::all();

        $articles = ArticleNews::with(['category'])
        ->where('is_featured', 'not_featured')
        ->latest()
        ->take(3)
        ->get();

        $featured_articles = ArticleNews::with(['category'])
        ->where('is_featured', 'featured')
        ->inRandomOrder()
        ->take(7)
        ->get();

        $bannerAds = BannerAdvertisement::where('is_active', 'active')
        ->where('type', 'banner')
        ->inRandomOrder()
        // ->take(1)
        ->first();

        $entertainment_articles = ArticleNews::whereHas('category', function($query){
            $query->where('name', 'Entertainment');
        })
        ->where('is_featured', 'not_featured')
        ->latest()
        ->take(6)
        ->get();

        $entertainment_featured_articles = ArticleNews::whereHas('category', function($query){
            $query->where('name', 'Entertainment');
        })
        ->where('is_featured', 'featured')
        ->inRandomOrder()
        ->first();

        $business_articles = ArticleNews::whereHas('category', function($query){
            $query->where('name', 'Business');
        })
        ->where('is_featured', 'not_featured')
        ->latest()
        ->take(6)
        ->get();

        $business_featured_articles = ArticleNews::whereHas('category', function($query){
            $query->where('name', 'Business');
        })
        ->where('is_featured', 'featured')
        ->inRandomOrder()
        ->first();

        $Automotive_articles = ArticleNews::whereHas('category', function($query){
            $query->where('name', 'Automotive');
        })
        ->where('is_featured', 'not_featured')
        ->latest()
        ->take(6)
        ->get();

        $Automotive_featured_articles = ArticleNews::whereHas('category', function($query){
            $query->where('name', 'Automotive');
        })
        ->where('is_featured', 'featured')
        ->inRandomOrder()
        ->first();
        
        $authors = Author::all();

        return view('front.index', compact('categories', 'articles', 'authors', 'featured_articles', 'bannerAds', 'entertainment_articles', 'business_articles', 'Automotive_articles', 'entertainment_featured_articles', 'business_featured_articles', 'Automotive_featured_articles'));
    }

    public function category(Category $category){
        $categories = Category::all();

        $bannerAds = BannerAdvertisement::where('is_active', 'active')
        ->where('type', 'banner')
        ->inRandomOrder()
        // ->take(1)
        ->first();

        return view('front.category', compact('categories', 'category' , 'bannerAds'));
    }

    public function author(Author $author){
        $categories = Category::all();

        $bannerAds = BannerAdvertisement::where('is_active', 'active')
        ->where('type', 'banner')
        ->inRandomOrder()
        // ->take(1)
        ->first();

        return view('front.author', compact('categories', 'author', 'bannerAds'));
    }

    public function details(ArticleNews $article_news){
        $categories = Category::all();

        $bannerAds = BannerAdvertisement::where('is_active', 'active')
        ->where('type', 'banner')
        ->inRandomOrder()
        // ->take(1)
        ->first();

        $squareAds = BannerAdvertisement::where('is_active', 'active')
        ->where('type', 'square')
        ->inRandomOrder()
        ->take(2)
        ->get();

        if($squareAds->count() <2) {
            $squareAds_1 = $squareAds->first();
            $squareAds_2 = null;
        } else {
            $squareAds_1 = $squareAds->get(0);
            $squareAds_2 = $squareAds->get(1);
        }

        $author_news = ArticleNews::where('author_id', $article_news->author_id)
        ->where('id', '!=', $article_news->id)
        ->inRandomOrder()
        ->take(3)
        ->get();

        $other_articles = ArticleNews::with(['category'])
        ->where('is_featured', 'not_featured')
        ->where('id', '!=', $article_news->id)
        ->inRandomOrder()
        ->take(3)
        ->get();

        return view('front.details', compact('categories', 'article_news', 'bannerAds', 'squareAds', 'author_news', 'other_articles', 'squareAds_1', 'squareAds_2'));
    }

    public function search(Request $request){

        $request->validate([
            'keyword' => ['required', 'string', 'max:255']  
        ]);

        $categories = Category::all();

        $keyword = $request->keyword;

        $articles = ArticleNews::with(['category', 'author'])
        ->where('name', 'like', '%'.$keyword.'%')
        ->paginate(6);

        return view('front.search', compact('categories', 'articles', 'keyword'));
    }
}