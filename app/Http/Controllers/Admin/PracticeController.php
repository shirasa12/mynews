<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Practice;


class PracticeController extends Controller
{
    //
  public function add()
  {
      return view('admin.practice.create');
  }
  
  
  public function create(Request $request)
  {
      
      // 以下を追記
      // Varidationを行う
      $this->validate($request, Practice::$rules);
      $practice = new Practice;
      $form = $request->all();

      // フォームから送信されてきた_tokenを削除する
      unset($form['_token']);
    
      // データベースに保存する
      $practice->fill($form);
      $practice->save();
      return redirect('admin/practice/create');
  }
  public function index(Request $request)
  {
      $cond_title = $request->cond_title;
      if ($cond_title != '') {
          // 検索されたら検索結果を取得する
          $posts = Practice::where('title', $cond_title)->get();
      } else {
          // それ以外はすべてのニュースを取得する
          $posts = Practice::all();
      }
      return view('admin.practice.index', ['posts' => $posts, 'cond_title' => $cond_title]);
  }
  public function edit(Request $request)
  {
      // News Modelからデータを取得する
      $practice = Practice::find($request->id);
      if (empty($practice)) {
        abort(404);    
      }
      return view('admin.practice.edit', ['practice_form' => $practice]);
  }


  public function update(Request $request)
  {
      // Validationをかける
      $this->validate($request, Practice::$rules);
      // News Modelからデータを取得する
      $practice = Practice::find($request->id);
      // 送信されてきたフォームデータを格納する
      $practice_form = $request->all();
      unset($practice_form['_token']);

      // 該当するデータを上書きして保存する
      $practice->fill($practice_form)->save();

      return redirect('admin/practice');
  }
   public function delete(Request $request)
  {
      // 該当するNews Modelを取得
      $practice = Practice::find($request->id);
      // 削除する
      $practice->delete();
      return redirect('admin/practice/');
  }  


}
