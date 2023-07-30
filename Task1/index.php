<!DOCTYPE html>
<html>

<body>

    <?php
    class MaxMin
    {
        // Properties
        public $numbers;

        function __construct($nums)
        {
            $this->numbers = $nums;
        }
        // Methods
        function sort_array()
        {
            sort($this->numbers);
        }
        function display_number()
        {
            return $this->numbers;
        }

        function findMax()
        {
            return max($this->numbers);
        }

        function findMin()
        {
            return min($this->numbers);
        }
    }

    $ob = new MaxMin([20, 13, 8, 40, 70]);

    $ob->sort_array();

    print_r($ob->display_number());
    echo "<br>";

    echo $ob->findMax();

    echo "<br>";

    echo $ob->findMin();
    ?>

</body>

</html>