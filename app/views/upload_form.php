<style>
    form div input {
        margin: 4px 0 0 0;
        min-width: 300px;
        height: 32px;
        border: 1px solid #a40;
        border-radius: 4px;
    }
    input[type="file"]{
        padding: 4px;
    }
    input {
        background-color: #ffffe0;
    }
    input[type="submit"] {
        background-color: #fea;
    }
</style>

<div>
    <form action="/main/form/post" method="post" <?=files::FORM_ATTRIBUTE?> >
        <div><input type="text" name="description" ></div>

        <div><input type="file" name="upfile" ></div>

        <div><input type="submit" value="Send"></div>
    </form>
</div>