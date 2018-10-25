<style>
.customBtn{
    font-weight: bold;
    color: #FFF;
}
</style>
<div class="all">
    <section>
        <div class="main">
            <form id="uploadForm" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="file" class="btn btn-danger customBtn">Choisissez plusieurs images</label>
                    <input type="file" multiple name="file[]" id="file" style="display: none;">
                    <div class="errors"></div>
                    <div class="imgContent"></div>
                </div>
            </form>
            <div class="treatment">
                <div class="creation"></div>
                <button class="btn btn-success clickView">Vue</button>
                <div class="view">VIEW DIV</div>
            </div>

        </div>
    </section>
    <div class="modifyImage">
        <span id="closeModifyImage">&#215;</span>
        <div id="imgDisplay"></div>
        <div id="imgTools">TOOLS</div>
    </div>
    <!-- <section class="second">
    
    </section> -->
</div>