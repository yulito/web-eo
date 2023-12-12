<?php

namespace Lib;

use App\Models\Category;
use App\Models\State;
use App\Models\Like;
use App\Models\Favourite;

trait Utils{

    public function showCategories(){ 
		$cat = new Category();
		$cat = $cat->getCat();
		return $cat;
    }
	public function showState(){
		$st = new State();
		$st = $st->getSt();
		return $st;
	}
	public function showLikes($id){
		$like = new Like();
		$result = $like->getLikes($id);
		return $result->fetch_object();
	}
	public function showLikeUser($id){
		$obj = new Like();
		$result = $obj->verifyUser($id);
		return $result;
	}
	public function showFavUser($id){
		$obj = new Favourite();
		$result = $obj->verifyFav($id);
		return $result;
	}
}