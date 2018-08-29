<?php
/**
 * User: Major
 * Date: 2018/4/28
 * Time: 0:56
 */

class HeapSort
{
    private $count;
    private $data;

    public function __construct(array $arr)
    {
        $this->count = count($arr);
        $this->data = $arr;
    }

    public function run()
    {
        $this->createHeap();
        while ($this->count > 0) {
            $this->swap($this->data[0], $this->data[--$this->count]);
            $this->buildHeap($this->data, 0, $this->count);
        }
        return $this->data;
    }

    public function createHeap()
    {
        $i = floor($this->count / 2);
        while ($i--) {
            $this->buildHeap($this->data, $i, $this->count);
        }
    }

    public function buildHeap(array &$data, $i, $count)
    {
        if (false === $i < $count) {
            return;
        }

        $right = ($left = 2 * $i + 1) + 1;
        $max = $i;
        if ($left < $count && $data[$i] < $data[$left]) {
            $max = $left;
        }
        if ($right < $count && $data[$max] < $data[$right]) {
            $max = $right;
        }

        if ($max !== $i && $max < $count) {
            echo $max . PHP_EOL;
            $this->swap($data[$i], $data[$max]);
            $this->buildHeap($data, $max, $count);
        }
    }

    public function swap(&$left, &$right)
    {
        list($left, $right) = array($right, $left);
    }
}

$arr = [4, 7, 6, 3, 9, 5, 8];
$data = (new HeapSort($arr))->run();
print_r($data);