<?php

/**
 * author: Major
 * description: 红黑树节点
 */
class Node
{
    public $key;
    public $parent;
    public $left;
    public $right;
    public $isRed; //分辨红节点或黑节点

    public function __construct($key, $isRed = true)
    {
        $this->key = $key;
        $this->parent = NULL;
        $this->left = NULL;
        $this->right = NULL;
        //插入节点默认是红色
        $this->isRed = $isRed;
    }
}

/**
 *  description: 红黑树
 */
class RedBlackTree
{
    public $root;

    /**
     * 初始化树结构
     * @param $arr
     * @return null
     */
    public function init($arr)
    {
        //根结点必须是黑色
        $this->root = new Node($arr[0], FALSE);
        for ($i = 1; $i < count($arr); $i++) {

        }
    }

    /**
     * （对内）中序遍历
     * @param Node $root
     */
    private function mid_order(Node $root)
    {
        if ($root != NULL) {
            $this->mid_order($root->left);
            echo $root->key . ' - ' . ($root->isRed ? 'red' : 'black') . ' ';
            $this->mid_order($root->right);
        }
    }

    /**
     * （对外中序遍历）
     */
    public function MidOrder()
    {
        $this->mid_order($this->root);
    }

    /**
     * 查找树中是否有存在$key对应的节点
     */
    public function search($key)
    {
        $current = $this->root;
        while ($current != null) {
            if ($current->key == $key) {
                return $current;
            } elseif ($current->key > $key) {
                $current = $current->left;
            } else {
                $current = $current->right;
            }
        }
        //节点不存在
        return $current;
    }

    /**
     * 将以$root为根节点的最小不平衡二叉树做右旋处理
     */
    private function R_route($root)
    {
        $L = $root->left;
        if (!is_null($root->parent)) {
            $P = $root->parent;
            if ($root = $P->left) {
                $P->left = $L;
            } else {
                $P->right = $L;
            }
        } else {
            $L->parent = NULL;
        }
        $root->parent = $L;
        $root->left = $L->right;
        $L->right = $root;

        if ($L->parent == NULL) {
            $this->root = $L;
        }
    }

    /**
     * 左移
     */
    private function L_route($root)
    {
        $R = $root->right;
        if (!is_null($root->parent)) {
            $P = $root->parent;
            if ($P->left == $root) {
                $P->left = $R;
            } else {
                $P->right = $R;
            }
            $R->parent = $P;
        } else {
            $R->parent = NULL;
        }
        $root->parent = $R;
        $root->right = $R->left;
        $R->left = $root;
        if ($R->parent == NULL) {
            $this->root = $R;
        }
    }

    /**
     * 查找树中的最小关键字
     */
    public function search_min($root)
    {
        $current = $root;
        while ($current->left != NULL) {
            $current = $current->left;
        }
        return $current;
    }

    /**
     * 查找树中最大的关键字
     */
    public function search_max($root)
    {
        $current = $root->right;
        while ($current->right != NULL) {
            $current = $current->right;
        }
        return $current;
    }

    /**
     * 查找某个$key在中序遍历时的直接前驱节点
     */
    public function predecessor($x)
    {
        //左子树存在，直接返回左子树的最右子节点
        if ($x->left != NULL) {
            return $this->search_max($x->left);
        }
        //否则查找其父节点
        $p = $x->parent;
        //如果x是p的左孩子，说明p是x的后继，我们需要找的是p是x的前驱
        while ($p != NULL && $x == $p->left) {
            $x = $p;
            $p = $x->parent;
        }
        return $p;
    }

    /**
     * 查找某个$key在中序遍历中的直接后继节点
     */
    public function successor($x)
    {
        if ($x->right != null) {
            return $this->search_min($x->right);
        }
        $p = $x->parent;
        while ($p != null && $x == $p->right) {
            $x = $p;
            $p = $x->parent;
        }
        return $p;
    }

    /**
     * 将$key插入树中
     */
    public function Insert($key)
    {
        if (!is_null($this->search($key))) {
            throw new Exception('节点 ' . $key . ' 已存在，不可插入!');
        }
        $root = $this->root;
        $inode = new Node($key);
        $current = $root;
        $preNode = NULL;
        //为$inode节点找到合适的插入位置
        while ($current != NULL) {
            $preNode = $current;
            if ($current->key > $inode->key) {
                $current = $current->left;
            } else {
                $current = $current->right;
            }
        }

        $inode->parent = $preNode;
        //如果$prenode == null ，则证明树是空树
        if ($preNode == NULL) {
            $this->root = $inode;
        } else {
            if ($inode->key < $preNode->key) {
                $preNode->left = $inode;
            } else {
                $preNode->right = $inode;
            }
        }

        //将它重新修正为一棵红黑树
        $this->InsertFixUp($inode);
    }

    /**
     * 对插入节点的位置及往上的位置进行颜色调整
     */
    private function InsertFixUp($inode)
    {
        //情况一:需要调整条件，父节点存在且父节点的颜色是红色的
        while (($parent = $inode->parent) != NULL && $parent->isRed == TRUE) {
            //祖父节点：
            $gparent = $parent->parent;

            //如果父节点是祖父节点的左子节点，下面的else与此相反
            if ($parent == $gparent->left) {
                //叔叔节点
                $uncle = $gparent->right;

                //case1: 叔叔节点也是红色
                if ($uncle != NULL && $uncle->isRed == TRUE) {
                    //将父节点和叔叔节点都涂黑，将祖父节点涂红
                    $parent->isRed = FALSE;
                    $uncle->isRed = False;
                    $gparent->isRed = TRUE;

                    //将新节点指向祖父节点（现在节点变红，可以看作新节点存在）
                    $inode = $gparent;

                    continue;
                }

                //case2: 叔叔节点是黑色的，且当前节点是右子节点
                if ($inode == $parent->right) {
                    //以父节点作为旋转节点 左旋操作
                    $this->L_route($parent);
                    //在树中实际上已经转换，但是这里的变量还没有交换
                    //将父节点的子节点调整一下，未下面右旋做准备
                    $temp = $parent;
                    $parent = $inode;
                    $inode = $temp;
                }

                //case3: 叔叔节点是黑色的，但是当前节点是左子节点
                $parent->isRed = FALSE;
                $gparent->isRed = True;
                $this->R_route($gparent);
            } //如果父节点是祖父节点的右子节点，与上面完全相反
            else {

            }
        }

        //情况二：插入节点是根结点（父节点为空），则只需将根结点涂黑
        if ($inode == $this->root) {
            $this->root->isRed = FALSE;
            return;
        }

        //情况三: 插入节点的父节点是黑色，则什么也不用做
        if ($inode->parent != NULL && $inode->parent->isRed == FALSE) {
            return;
        }
    }

    /**
     * 删除指定节点
     */
    public function delete($key)
    {
        if (is_null($this->search($key))) {
            throw new Exception('节点 ' . $key . ' 不存在，删除失败!');
        }
        $dnode = $this->search($key);
        if ($dnode->left == NULL || $dnode->right == NULL) {
            $c = $dnode;
        } else {
            //如果待删除节点有两个子节点，c置为dnode的直接后继，以待最后将待删除节点的值换为其后继的值
            $c = $this->successor($dnode);
        }

        //为了后面颜色处理做准备
        $parent = $c->parent;

        //无论前面情况如何，到最后c只剩下一边子节点
        if ($c->left != NULL) {
            $s = $c->left;
        } else {
            $s = $c->right;
        }

        //将c的子节点的父母节点置为c的父母节点
        if ($s != NULL) {
            $s->parent = $c->parent;
        }

        //如果c的父节点为空，删除根节点后直接将根结点置为根结点的子节点，此处dnode是根结点，且拥有两个子节点，则c是dnode的后继结
        //点，c的父母就不会为空，就不会进入这个if
        if ($c->parent == NULL) {
            $this->root = $s;
        } else if ($c == $c->parent->left) {
            $c->parent->left = $s;
        } else {
            $c->parent->right = $s;
        }

        //c的节点是黑色，那么会影响路径上的黑色节点的数量，必须进行调整
        $dnode->key = $c->key;

        $node = $s;

        //c的节点颜色是黑色，那么会影响路径上的黑色节点的数量，必须进行调整
        if ($c->isRed == FALSE) {

        }
    }

    /**
     * 删除节点后对节点周围的其它节点进行调整
     */
    private function deleteFixUp($node, $parent)
    {
        //如果待删除的子节点为红色，直接将子节点涂黑
        if ($node != NULL && $node->isRed == TRUE) {
            $node->isRed = FALSE;
            return;
        }

        //如果是根结点，那就直接将根结点置为黑色即可
        while (($node == NULL || $node->isRed == FALSE) && ($node != $this->root)) {
            //node是父节点的左子节点，下面的else与这里相反
            if ($node = $parent->left) {
                $brother = $parent->right;

                //case1: 兄弟节点颜色是红色的（父节点和兄弟孩子结点都是黑色的）
                //将父节点涂红，将兄弟节点涂黑，然后对父节点进行左旋转
                //经过这一步，情况转换为兄弟节点颜色为黑色的情况
                if ($brother != NULL && $brother->isRed == TRUE) {
                    $parent->isRed = TRUE;
                    $brother->isRed = FALSE;
                    $this->L_route($parent);
                    //将情况转化为其它的情况
                    $brother = $parent->right; //在左旋转处理后，$parent->right指向原来兄弟节点的左子节点
                }

                //case2:以下是兄弟节点为黑色的情况,并且兄弟节点的两个子节点都是黑色
                if (($brother->left == NULL || $brother->left->isRed == FALSE) &&
                    ($brother->right == NULL || $brother->right->isRed == FALSE)) {
                    $brother->isRed = TRUE;
                    $node = $parent;
                    $parent = $node->parent;
                } else {
                    //case3:兄弟节点是黑色，兄弟节点的左子节点是红色，右子节点是黑色
                    if ($brother->right == NULL || $brother->right->isRed == FALSE) {
                        $brother->isRed = TRUE;
                        $brother->isRed = FALSE;
                        $this->R_route($brother);

                        //讲情况转换为其它情况
                        $brother = $parent->right;
                    }

                    //case4: 兄弟节点是黑色，且兄弟节点的右子节点是红色，左子节点为任意颜色
                    $brother->isRed = $parent->isRed;
                    $brother->isRed = TRUE;
                    $brother->right = FALSE;
                    $this->L_route($parent);
                    //到了第四种情况,已经是基本的情况了，可以直接退出了
                    $node = $this->root;
                    break;
                }
            } else {

            }
        }
    }


}