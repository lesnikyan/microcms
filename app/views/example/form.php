<style>
    form div input, form div select, form textarea {
        margin: 4px 0 0 0;
        min-width: 300px;
        border: 1px solid #a40;
        border-radius: 4px;
    }
    input[type="file"]{
        padding: 4px;
    }
    input, select {
        height: 32px;
        background-color: #ffffe0;
    }
    input[type="submit"] {
        background-color: #fea;
    }
    form textarea {
        width: 300px;
        height: 200px;
        background-color: #ffffe0;
        border: 1px solid #a40;
    }
</style>

<?php
    $ftype = function($f) use ($types){
        if(isset($types[$f])){
            return $types[$f];
        }
        return 'string';
    }
?>

<div>
    <div>Fields:</div>
    <form action="/example/save" method="post">
        <?php foreach($data as $f => $val): ?>
        <?php if($f == 'id'): ?>
        <input type="hidden" name="<?=$f?>" value="<?=$val?>">
        <?php elseif($ftype($f) == 'text'): ?>
        <div><?=$f?>:</div>
        <div><textarea name="<?=$f?>" ><?=$val?></textarea></div>
        <?php elseif($ftype($f) == 'enum'): ?>
        <div><select name="<?=$f?>" >
            <?php foreach($types['_enums'][$f] as $enval):?>
            <option value="<?=$enval?>" <?=(($enval == $val) ? 'selected' : '')?> ><?=$enval?></option>
            <?php endforeach;?>
        </select> : <?=$f?></div>
        <?php else: ?>
        <div><input type="text" name="<?=$f?>" value="<?=$val?>"> : <?=$f?></div>
        <?php endif; ?>
        <?php endforeach; ?>
        <div><input type="submit" value="Save"></div>
    </form>
</div>