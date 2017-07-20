<?php

/**
 * 分页工具条
 * Class PageTool
 */
class SearchPageTool
{
    /**
     * @param $count 总条数
     * @param $pageSize 每页显示多少条
     * @param string $pageParam 分页的参数
     */
    public static function SearchPage($list_name,$search1='',$search2='',$search3='',$search4='',$search5='',$search6=''){
	    $wherelist=array();
	    $urlist=array();

	    for ($i=1;$i<7;$i++){
		    $a="search$i";

		    if(!empty($_GET["${$a}"]))
		    {

			    $wherelist[]=" ".$$a." like '%".$_GET["${$a}"]."%'";
			    $urllist[]="${$a}=".$_GET["${$a}"];

		    }
	    }

	    $where="";
	    if(count($wherelist)>0)
	    {
		    $where=" where ".implode(' and ',$wherelist);
		    $url='&'.implode('&',$urllist);
	    }
//分页的实现原理
//1.获取数据表中总记录数
	    $sql="select count(*) from $list_name $where ";
	    $result=mysqli_query($sql);
	    $totalnum=mysqli_num_rows($result);
//每页显示条数
	    $pagesize=5;
//总共有几页
	    $maxpage=ceil($totalnum/$pagesize);
	    $page=isset($_GET['page'])?$_GET['page']:1;
	    if($page <1)
	    {
		    $page=1;
	    }
	    if($page>$maxpage)
	    {
		    $page=$maxpage;
	    }
	    $limit=" limit ".($page-1)*$pagesize.",$pagesize";
	    $sql1="select * from news {$where} {$limit}";

//$sql1="select * from news {$where} {$limit}";
	    $res=mysql_query($sql1);
        $html = <<<HTML
        <table id="page-table" cellspacing="0">
                <tbody>
                    <tr>
                        <td align="right" nowrap="true" style="background-color: rgb(255, 255, 255);">
                            <div id="turn-page">
            总计  <span id="totalRecords">{$count}</span>个记录分为 <span id="totalPages">{$total}</span>页当前第 <span id="pageCurrent">{$page}</span>
        页，每页 <input type="text" size="3" id="pageSize" value="{$pageSize}" onkeypress="return listTable.changePageSize(event)">
        <span id="page-link">
                                    <a href="{$url}&page=1">第一页</a>
                                    <a href="{$url}&page={$pre_page}">上一页</a>
                                    <a href="{$url}&page={$next_page}">下一页</a>
                                    <a href="{$url}&page={$total}">最末页</a>
                                </span>
                            </div>
                        </td>
                 </tr>
        </tbody>
        </table>
HTML;

        //返回分页条
        return $html;
    }
}