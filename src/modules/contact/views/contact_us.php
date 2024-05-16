<div class="container my-5">
    <h1><?php echo $p->title; ?></h1>
    <?php echo $p->content; ?>
    <form action="/" method="post">
        <input type="hidden" name="section" value="submit_contact_us">
        <input type="hidden" name="action" value="submit">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
            <label for="textInput" class="form-label">Message</label>
            <input type="text" class="form-control" id="textInput">
        </div>
        <button type="submit" class="btn btn-primary">Send</button>
    </form>
</div>