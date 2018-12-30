<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TopController extends Controller
{

    public function index()
    {
        return view('top.index');
    }

    public function create(Request $request) {
        $this->validate($request, [
            'image' => [
                // 必須
                'required',
                // アップロードされたファイルであること
                'file',
                // 画像ファイルであること
                'image',
                // MIMEタイプを指定
                'mimes:jpeg,png',
                // 最小縦横120px 最大縦横400px
                // 'dimensions:min_width=120,min_height=120,max_width=400,max_height=400',
            ]
        ]);
        if ($request->file('image')->isValid()) {
            // 画像ファイルの保存 & 背景透過
            $imageFilename = $request->image->store('images/result');
            $inputFileFullPath = storage_path() . '/app/' . $imageFilename;
            $now = new \DateTime();
            $outputFileFullPath = public_path() . '/' . $imageFilename . '.' . $now->format('YmdHis') . '.png';
            $convertLibDir = app_path() . '/Lib/image-background-removal/';
            $convertLibName = 'seg.py';
            $convertCommand = "python {$convertLibDir}{$convertLibName} {$inputFileFullPath} {$outputFileFullPath}"; // 背景透過コマンド
            Log::info($convertCommand);
            exec("cd {$convertLibDir} && $convertCommand"); // 背景透過処理の実行

            return view('top.create')->with([
                'imageUrl' => basename($outputFileFullPath),
            ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['image' => '画像がアップロードされていないか不正なデータです。']);
        }
    }
}
