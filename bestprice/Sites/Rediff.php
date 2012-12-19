<?php
class Rediff extends Parsing{
	public $_code = 'Rediff';

	public function getAllowedCategory(){
		return array(Category::BOOKS);
	}

	public function getWebsiteUrl(){
		return 'rediff.com';
	}
	public function getSearchURL($query,$category = false){
		if($category == Category::BOOKS){
			return "http://books.rediff.com/search/$query?&output=xml&src=search_$query";
		}else{
			return "http://shopping.rediff.com/shopping/index.html#!".urldecode($query);
		}
	}
	public function getLogo(){
		return "http://books.rediff.com/booksrediff/pix/rediff.png";
	}
	public function getData($html,$query,$category){
		$data = array();

		$xmlObj = new SimpleXMLElement($html);
		$match = $xmlObj->QueryMatch->total;
		if($match > 0){
			foreach($xmlObj->QueryMatch->book as $book){
				$name = $book->title."";
				$isbn = $book->isbn."";
				$author = $book->author.'';
				$image = $book->imagesmall.'';
				$disc_price = $book->domesticwebprice.'';
				$url = $book->book_url.'';
				$shipping = $book->despatchleadtime.' Working Days';
				$cat = '';
				$stock = 0;
				$offer = '';
				$data[] = array(
						'name'=>$name,
						'image'=>$image,
						'disc_price'=>$disc_price,
						'url'=>$url,
						'website'=>$this->getCode(),
						'offer'=>$offer,
						'shipping'=>$shipping,
						'stock'=>$stock,
						'author' => $author,
						'isbn' => $isbn,
						'cat' => $cat
				);
			}
		}
		$data = $this->cleanData($data, $query);
		$data = $this->bestMatchData($data, $query);
		return $data;
	}
}