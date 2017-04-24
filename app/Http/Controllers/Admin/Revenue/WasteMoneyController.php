<?php

namespace App\Http\Controllers\Admin\Revenue;

use App\Game;
use App\TaxDailyStatistic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WasteMoneyController extends Controller
{
    public function index(Request $request){
        $timeRequest = \Request::get('timeRequest') ? explode(" - ", \Request::get('timeRequest')) : null;
        $game = \Request::get('game');
        $gameArr = Game::pluck('name', 'gameId');
        $gameArr->prepend('---Tất cả---', '');

        $list_games = Game::getListGame($game);

        $results = TaxDailyStatistic::getRevenueGroupByDateFromTo($game, $timeRequest);

        $data = [];
        foreach ($results as $rs){
            $data[$rs->day][$rs->gameId] = $rs->taxValue;
        }
        return view('admin.revenue.wasteMoney.index',compact('gameArr', 'list_games', 'data'))->with('i', ($request->input('page', 1) - 1) * 10);
    }

    public function downloadExcel(){

        $timeRequest = \Request::get('timeRequest') ? explode(" - ", \Request::get('timeRequest')) : null;
        $game = \Request::get('game');
        $gameArr = Game::pluck('name', 'gameId');
        $gameArr->prepend('---Tất cả---', '');

        $list_games = Game::getListGame($game);

        $results = TaxDailyStatistic::getRevenueGroupByDateFromTo($game, $timeRequest);

        // generator.
        $data = [];

        // Convert each member of the returned collection into an array,
        // and append it to the payments array.
        foreach ($results as $k => $result) {
            $data[] = $result->toArray();
        }
        // Generate and return the spreadsheet

        return \Maatwebsite\Excel\Facades\Excel::create('user_reg', function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $headings = array('Tên tài khoản', 'Tên hiển thị','IP','Thiết bị','Đối tác', 'Nền tảng', 'Ngày đăng ký');
                $sheet->fromArray($data, null, 'A1', false, false);
                $sheet->prependRow(1, $headings);
            });
        })->download('xlsx');
    }
}
