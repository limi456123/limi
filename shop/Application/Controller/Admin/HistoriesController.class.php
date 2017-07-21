<?php


class HistoriesController extends Controller
{
   public function index(){
       $historiesModel=new HistoriesModel();
       $rows=$historiesModel->getAll();

       $this->assign( "rows",$rows);
       $this->display("histories_index");

   }

}