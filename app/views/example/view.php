<?php
    $fields = array_keys($info);
?>
<style>
    td{
        min-width: 100px;
    }
    td, th {
        height: 30px;
        text-align: left;
        padding-left: 4px;
    }
</style>
<table>
<?php foreach($fields as $f): ?>
    <tr>
        <th><?=$f?>:</th> <td><?=$info[$f]?></td>
    </tr>
<?php endforeach; ?>
</table>
<div> <a href="/example/edit/<?=$info['id']?>" class="menu">Edit</a> </div> 