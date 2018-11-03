<style>
.customBtn{
    font-weight: bold;
    color: #FFF;
}
.functions div{display: block;}
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
                <button class="btn btn-success clickView">Mix</button>
                <div class="view"></div>
            </div>

        </div>
    </section>
    <div class="modifyImage">
        <span id="closeModifyImage">&#215;</span>
        <div id="imgDisplay"></div>
        <div id="imgTools">TOOLS</div>
    </div>
                <div class="form-group functions">
                    <div class="pixel">
                        <legend>Pixel</legend>
                        <div class="group">
                            <input type="radio" id="pixeliseBoolTrue" name="pixeliseBool" value="0" checked />
                            <label for="pixeliseBoolTrue">true</label>
                            <input type="radio" id="pixeliseBoolFalse" name="pixeliseBool" value="1" />
                            <label for="pixeliseBoolFalse">false</label>
                        </div>
                        <div class="group">
                            pixelIncrementX<input type="number" name="pixelIncrementX" id="pixelIncrementX" value="50">
                            pixelIncrementY<input type="number" name="pixelIncrementY" id="pixelIncrementY" value="50">
                        </div>
                        <div class="group">
                            pixelDivider<input type="number" name="pixelDivider" id="pixelDivider" value="2">                  
                            pixelOperator
                            <input type="radio" id="pixelOperatorTrue" name="pixelOperator" value="0" checked />
                            <label for="pixelOperatorTrue">true</label>
                            <input type="radio" id="pixelOperatorFalse" name="pixelOperator" value="1" />
                            <label for="pixelOperatorFalse">false</label> 

                            pixelOrientationX<input type="number" name="pixelOrientationX" id="pixelOrientationX" value="0">                  
                            pixelOrientationY<input type="number" name="pixelOrientationY" id="pixelOrientationY" value="0">                  
                        </div>
                    </div>
                    <div class="form-group quadrillage">
                        <legend>quadrillage</legend>
                        <div class="group">
                            <input type="radio" id="quadriTrue" name="quadri" value="0" checked />
                            <label for="quadriTrue">true</label>
                            <input type="radio" id="quadriFalse" name="quadri" value="1" />
                            <label for="quadriFalse">false</label>
                        </div>
                        <div class="group">	
                            quadrillageH
                            <input type="radio" id="quadrillageHTrue" name="quadrillageH" value="0" checked />
                            <label for="quadrillageHTrue">true</label>
                            <input type="radio" id="quadrillageHFalse" name="quadrillageH" value="1" />
                            <label for="quadrillageHFalse">false</label> 

                            quadrillageV
                            <input type="radio" id="quadrillageVTrue" name="quadrillageV" value="0" checked />
                            <label for="quadrillageVTrue">true</label>
                            <input type="radio" id="quadrillageVFalse" name="quadrillageV" value="1" />
                            <label for="quadrillageVFalse">false</label> 
                        </div>
                        <div class="group">
                            quadriPixelIncrementX<input type="number" name="quadriPixelIncrementX" id="quadriPixelIncrementX" value="50">
                            quadriPixelIncrementY<input type="number" name="quadriPixelIncrementY" id="quadriPixelIncrementY" value="50">
                        </div>
                        <div class="group">
                            quadriThickH<input type="number" name="quadriThickH" id="quadriThickH" value="0">
                            quadriThickV<input type="number" name="quadriThickV" id="quadriThickV" value="0">
                        </div>
                        <div class="group">
                            quadriColorRandomBool
                            <input type="radio" id="quadriColorRandomBoolTrue" name="quadriColorRandomBool" value="0" checked />
                            <label for="quadriColorRandomBoolTrue">true</label>
                            <input type="radio" id="quadriColorRandomBoolFalse" name="quadriColorRandomBool" value="1" />
                            <label for="quadriColorRandomBoolFalse">false</label> 
                        </div>
                        <div class="group">
                            quadriColorH <input type="text" name="quadriColorH" id="quadriColorH" value="[0, 0, 0]">
                            quadriColorV <input type="text" name="quadriColorV" id="quadriColorV" value="[255, 255, 255]">
                        </div>
                        <div class="group">
                            quadriTypeH
                            <input type="radio" id="quadriTypeHTrue" name="quadriTypeH" value="0" checked />
                            <label for="quadriTypeHTrue">true</label>
                            <input type="radio" id="quadriTypeHFalse" name="quadriTypeH" value="1" />
                            <label for="quadriTypeHFalse">false</label> 

                            quadriTypeV
                            <input type="radio" id="quadriTypeVTrue" name="quadriTypeV" value="0" checked />
                            <label for="quadriTypeVTrue">true</label>
                            <input type="radio" id="quadriTypeVFalse" name="quadriTypeV" value="1" />
                            <label for="quadriTypeVFalse">false</label> 
                        </div>
                    </div>
                    <div class="form-group merge">
                        <legend>Auto Merge</legend>
                        <div class="group">
                            <input type="radio" id="mergeTrue" name="merge" value="0" checked />
                            <label for="mergeTrue">true</label>
                            <input type="radio" id="mergeFalse" name="merge" value="1" />
                            <label for="mergeFalse">false</label> 

                            Automerge shift <input type="number" name="mergeShift" id="mergeShift" value="50">
                        </div>
                    </div>
                </div>
    <!-- <section class="second">
    
    </section> -->
</div>