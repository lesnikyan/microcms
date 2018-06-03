<style>
    table {
        background-color: #f0f4ff;
        border: 1px solid #def;
        border-collapse: collapse;
    }
    th {
        background-color: #e0f0ff;
    }
    td {
        border-top: 1px solid #def;
        border-right: 1px solid #e0f8ff;
        padding-left: 2px;
        padding-right: 2px;
    }

    a.actions {
        color: #369;
        background-color: #def;
        border: 1px solid #8be;
        display: inline-block;
        margin: 2px;
        border-radius: 4px;
        padding: 0 2px 0 2px;
        text-decoration: none;
    }
    a.alert{
        color: red;
    }
</style>

<h1>Item list.</h1>

<div>
    <table>
        <tr>
            <?php foreach($fields as $f):?>
            <th><?=$f?></th>
            <?php endforeach; ?>
            <th>Edit</th>
        </tr>
        <?php foreach($items as $item):?>
        <tr>
            <?php foreach($fields as $f):?>
            <td><?=(strlen($item->{$f})<=8 ? $item->{$f} : substr($item->{$f}, 0, 8).'...')?></td>
            <?php endforeach; ?>
            <td>
                <a class="actions" href="/example/edit/<?=$item->id?>">Edit</a>
                <a class="actions" href="/example/view/<?=$item->id?>">Details</a>
                <a class="actions alert" href="/example/del/<?=$item->id?>">Delete</a>    
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>