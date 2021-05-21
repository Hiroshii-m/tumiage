window.addEventListener("DOMContentLoaded", function() {
    // ********************************************************
    // 変数
    // ********************************************************
    var $headerNav = document.querySelector('.js-header-nav'),
        $headerList = document.querySelector('.js-header-list'),
        $spMenuTarget = document.querySelector('.js-sp-menu-target'),
        $ftr = document.querySelector('#l-footer'),
        $showMsg,
        $goTop,
        $areaDrops,
        $fileInputs,
        $avatarImgs;

        $showMsg = document.querySelector(".js-show-msg") || null;
        $goTop = document.querySelector(".js-goTop") || null;
        $areaDrops = document.querySelectorAll(".js-area-drop") || null;
        $fileInputs = document.querySelectorAll(".js-file-input") || null;
        $avatarImgs = document.querySelectorAll(".js-avatar-img") || null;

    // ********************************************************
    // 関数
    // ********************************************************
    
    // ********************************************************
    // 処理内容
    // ********************************************************
    // 画像がなければ、imgタグを非表示
    if($avatarImgs !== null){
        $avatarImgs.forEach(function($img) {
            if(!$img.getAttribute('src')) {
                $img.classList.add("u-display-none");
            }else{
                $img.classList.remove("u-display-none");
            }
        });
    }
    // 画像プレビューの処理
    if($areaDrops !== null){
        $areaDrops.forEach(function($areaDrop) {
            $areaDrop.addEventListener("dragover", function(e) {
                e.stopPropagation();
                e.preventDefault();
                this.classList.add("active");
            });
            $areaDrop.addEventListener("dragleave", function(e) {
                e.stopPropagation();
                e.preventDefault();
                this.classList.remove("active");
            });
        });
    }
    if($fileInputs !== null){
        $fileInputs.forEach(function($fileInput) {
            $fileInput.addEventListener("change", function() {
                $areaDrops.forEach(function($areaDrop) {
                    $areaDrop.classList.remove("active");
                });
                var file = this.files[0],
                    $img = this.nextElementSibling,
                    $text = $img.nextElementSibling,
                    fileReader = new FileReader();
        
                fileReader.onload = function(event) {
                    $img.setAttribute("src", event.target.result);
                    $img.classList.remove("u-display-none");
                    $text.classList.add("u-display-none");
                }
            
                fileReader.readAsDataURL(file);
            });
        });
    }
    // フッター要素を最下部に固定
    if(window.innerHeight > $ftr.offsetTop + $ftr.offsetHeight ){
        $ftr.classList.add("active");
    }
    // js-goTopボタンを押した場合、トップへ移動する
    if($goTop !== null) {
        $goTop.addEventListener("click", function() {
            scrollTo(0, 0);
        });
    }
    // フラッシュメッセージの動き
    if($showMsg !== null) {
        if($showMsg.textContent.replace(/^[\s　]+|[\s　]+$/g, "").length) {
            setTimeout(function(){ $showMsg.classList.add('active'); }, 10);
            setTimeout(function(){ $showMsg.classList.remove('active'); }, 8000);
        }
    }
    window.addEventListener("scroll", function() {
        if($spMenuTarget.offsetTop < window.scrollY) {
            $headerNav.classList.add('active');
            $headerList.classList.add('active');
        } else {
            $headerNav.classList.remove('active');
            $headerList.classList.remove('active');
        }
    });
});