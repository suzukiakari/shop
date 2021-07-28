$(function(){
  $("#myfile").on('change', function(e){

    //ファイルオブジェクトを取得する
    var file = e.target.files[0];
    var reader = new FileReader();
   
    //アップロードした画像を設定する
    reader.onload = (function(file){
    return function(e){
      $("#img1").attr("src", e.target.result);
      $("#img1").attr("title", file.name);
      };
    })(file);
      reader.readAsDataURL(file);
  });
});

// $(function(){
	
// 		var imgWidth = $('.sample img').width();
// 		var imgHeight = $('.sample img').height();
		
// 		var aspectRatio = imgWidth / imgHeight
	
// 		if(aspectRatio >= 1){
// 			//横長画像の場合 divのheightに数値を合わせる
// 			$('.sample img').css('height','200px');
// 		}else{
// 			//縦長画像の場合 divのwidthに数値を合わせる
// 			$('.sample img').css('width','300px');

// 			//上下中央揃えにする場合は下記2行も
// 			var i = (imgHeight-200)/2  //はみ出た部分を計算して÷2し、ネガティブマージンをつける
// 			$(this).find('img').css('margin-top', '-'+i+'px');

// 		}
	
	
// });
//https://javascript.programmer-reference.com/jquery-image-preview/