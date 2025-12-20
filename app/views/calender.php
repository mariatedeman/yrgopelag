<!-- <link rel="stylesheet" href="/assets/styles/library-components.css"> -->

<?php
$firstDayOfMonth = date('N', mktime(0, 0, 0, 1, 1, 2026));
$lastDayOfMonth = date('N', mktime(0, 0, 0, 1, 31, 2026));
$daysInMonth = date('t', mktime(0, 0, 0, 1, 1, 2026));
$dayInWeek = date('l', mktime(0, 0, 0, 1, 1, 2026));
?>

<table class="calender">
    <caption>January 2026</caption>

    <tr>
        <th>M</th>
        <th>T</th>
        <th>W</th>
        <th>T</th>
        <th>F</th>
        <th>S</th>
        <th>S</th>
    </tr>

    <tr>
        <?php for ($i = 1; $i < $firstDayOfMonth; $i++) : ?>
            <td class="day"></td>
        <?php endfor;

        for ($i = 1; $i <= $daysInMonth; $i++) : ?>
            <td class="day"><?= $i ?></td>

            <?php if (($i + $firstDayOfMonth - 1) % 7 === 0) : ?>
    </tr>
    <tr>
    <?php endif;
        endfor;

        if ($lastDayOfMonth !== 7) :
            for ($lastDayOfMonth; $lastDayOfMonth < 7; $lastDayOfMonth++) : ?>
        <td class="day"></td>

<?php endfor;
        endif;

?>



    </tr>


</table>




<!-- 
<div class="month">
    <ul>
        <li class="prev"><</li>
        <li class="next">></li>
        <li>January 2026</li>
    </ul>
</div>

<ul class="weekdays">
    <li>M</li>
    <li>T</li>
    <li>W</li>
    <li>T</li>
    <li>F</li>
    <li>L</li>
    <li>S</li>
</ul>

<ul class="days">
    <li>1</li>
    <li>2</li>
    <li>3</li>
    <li>4</li>
    <li>5</li>
    <li>6</li>
    <li>7</li>
    <li>8</li>
    <li>9</li>
    <li>10</li>
    <li>11</li>
    <li>12</li>
    <li>13</li>
    <li>14</li>
    <li>15</li>
    <li>16</li>
    <li>17</li>
    <li>18</li>
    <li>19</li>
    <li>20</li>
    <li>21</li>
    <li>22</li>
</ul> -->