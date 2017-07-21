<?php

/**
 * 分页工具条
 * Class PageTool
 */
class SearchPageTool extends Model
{
    /**
     * @param $list_name 查询的表名
     * @param $url 地址前部分,比如 index.php?p=Admin&c=Login&a=index
     * @param string $pageParam 分页的参数 即 GET 传递页码 用的键名. 一般是page.
     * @param $search1 搜索时 用的GET 传递搜索参数的键.
     *
     */
    public function SearchPage($list_name,$url,$pageParam = "page",$search1='',$search2='',$search3='',$search4='',$search5='',$search6=''){
	    $wherelist=array();
	    $urllist=array();

	    for ($i=1;$i<7;$i++){
		    $a="search$i";

		    if(!empty($_GET["${$a}"]))
		    {
			    $wherelist[]=" ".addslashes($$a)." like '%".addslashes($_GET["${$a}"])."%'";
			    $urllist[]=addslashes($$a)."=".addslashes($_GET["${$a}"]);

		    }
	    }

	    $where="";
	    if(count($wherelist)>0)
	    {
		    $where=" where ".implode(' and ',$wherelist);
		    $searchurl='&'.implode('&',$urllist);
	    }
//分页的实现原理
//1.获取数据表中总记录数
	    $sql="select count(*) from $list_name $where ";
	    $totalnum=$this->db->fetchColumn($sql);
//每页显示条数
	    $pagesize=5;
//总共有几页
	    $maxpage=ceil($totalnum/$pagesize);
	    $page=isset($_GET[$pageParam])?$_GET[$pageParam]:1;
	    if($page <1)
	    {
		    $page=1;
	    }
	    if($page>$maxpage)
	    {
		    $page=$maxpage;
	    }

	    //上一页
	    $pre_page = ($page-1) < 1 ? 1: ($page-1);
	    //下一页
	    $next_page = ($page+1) > $maxpage ? $maxpage : ($page+1);

	    $limit=" limit ".($page-1)*$pagesize.",$pagesize";
	    $sql1="select * from $list_name {$where} {$limit}";

//$sql1="select * from news {$where} {$limit}";
	    $rows=$this->db->fetchAll($sql1);
        $html = <<<HTML
        <table id="page-table" cellspacing="0">
                <tbody>
                    <tr>
                        <td align="right" nowrap="true" style="background-color: rgb(255, 255, 255);">
                            <div id="turn-page">
            总计  <span id="totalRecords">{$totalnum}</span>个记录分为 <span id="totalPages">{$maxpage}</span>页当前第 <span id="pageCurrent">{$page}</span>
        页，每页 <input type="text" size="3" id="pageSize" value="{$pagesize}" onkeypress="return listTable.changePageSize(event)">
        <span id="page-link">
                                    <a href="{$url}&page=1{$searchurl}">第一页</a>
                                    <a href="{$url}&page={$pre_page}{$searchurl}">上一页</a>
                                    <a href="{$url}&page={$next_page}{$searchurl}">下一页</a>
                                    <a href="{$url}&page={$maxpage}{$searchurl}">最末页</a>
                                </span>
                            </div>
                        </td>
                 </tr>
        </tbody>
        </table>
HTML;
		//返回搜索出的所有记录
        //返回分页条
	    $result=['rows'=>$rows,'html'=>$html];
        return $result;
    }
}