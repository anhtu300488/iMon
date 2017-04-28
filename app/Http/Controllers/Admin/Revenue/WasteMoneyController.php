<?php

namespace App\Http\Controllers\Admin\Revenue;

use App\Game;
use App\TaxDailyStatistic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

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
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 50;
        return view('admin.revenue.wasteMoney.index',compact('gameArr', 'list_games', 'data'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }

    public function downloadExcel(Request $request){

        $timeRequest = \Request::get('timeRequest') ? explode(" - ", \Request::get('timeRequest')) : null;
        $game = \Request::get('game');

        $list_games = Game::getListGame($game);

        $results = TaxDailyStatistic::getRevenueGroupByDateFromTo($game, $timeRequest);
        $headings = ['Ngày'];
        foreach($list_games  as $valgame){
            array_push($headings,$valgame['name']);
        }
        // generator.
        $data = [];

        // Convert each member of the returned collection into an array,
        // and append it to the payments array.
        foreach ($results as $rs){
            $data[$rs->day][$rs->gameId] = $rs->taxValue;
        }
        // Generate and return the spreadsheet
        $list_data = [];
        $list_data_arr = [];
            foreach ($data as $key => $rs){
                $list_data['day'] = $key;
                foreach ($list_games as $valgame){
                    if(isset($rs[$valgame['gameId']])){
                        $list_data[$valgame['gameId']] = number_format($rs[$valgame['gameId']]);
                    }else {
                        $list_data[$valgame['gameId']] = '-';
                    }
                }
                array_push($list_data_arr,$list_data);
            }


        return \Maatwebsite\Excel\Facades\Excel::create('waste_money', function($excel) use ($list_data_arr, $headings) {
            $excel->sheet('mySheet', function($sheet) use ($list_data_arr, $headings)
            {
                $sheet->fromArray($list_data_arr, null, 'A1', false, false);
                $sheet->prependRow(1, $headings);
            });
        })->download('xlsx');
    }
}
