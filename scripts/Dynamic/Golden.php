<?php

class Golden
{
    /**
     * 动态规划：
     * 1）最优子结构
     * 2）边界
     * 3）状态转移函数
     *
     * F(n,w)=0; n<1 || w<p[0]
     * F(n,w)=g[0]; n==1 && w>=p[0]
     * F(n,w) = F(n-1,w); n>1 && w<p[n-1]
     * F(n,w) = max(F(n-1,w),F(n-1,w-p[n-1])+g[n-1]); n>1 && w>=p[n-1]
     *
     * 动态规划 黄金问题
     * n 表示第几座黄金 w表示工人数量
     * $g 存储每一座黄金数量
     * $p 存储每一座黄金需要的工人数
     * @param $n
     * @param $w
     * @param array $g
     * @param array $p
     * @return array
     */
    public static function getMostGold($n, $w, array $g, array $p)
    {
        $preResults = array();
        //填充边界格子的值
        for ($i = 1; $i <= $w; $i++) {
            if ($i < $p[0]) {
                $preResults[$i] = 0;
            } else {
                $preResults[$i] = $g[0];
            }
        }

        $result = array();
        //填充其余的格子，外层循环是金矿的数量，内层循环是工人数
        for ($i = 1; $i < $n; $i++) {
            for ($j = 1; $j <= $w; $j++) {
                if ($j < $p[$i]) {
                    $result[$j] = $preResults[$j];
                } else {
                    $result[$j] = max($preResults[$j], (($j - $p[$i] > 0 ? $preResults[$j - $p[$i]] : 0) + $g[$i]));
                }
            }
            $preResults = $result;
        }
        return $result;
    }

}

$n = 5;
$w = 10;
$g = [400, 500, 200, 300, 350];
$p = [5, 5, 3, 4, 3];
$ret = Golden::getMostGold($n, $w, $g, $p);
print_r($ret);