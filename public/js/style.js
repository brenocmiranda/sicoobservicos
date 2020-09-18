
// Função pré visualização de imagem do usuário
function image(input){
	if(input.files && input.files[0]){
		var reader = new FileReader();
		reader.onload = function (oFREvent){
			$('#PreviewImage').attr('src', oFREvent.target.result);
		}
		reader.readAsDataURL(input.files[0]);
	}
}

// Função pré visualização de imagem do usuário
function image1(input){
	if(input.files && input.files[0]){
		var reader = new FileReader();
		reader.onload = function (oFREvent){
			$('#PreviewImageEdit').attr('src', oFREvent.target.result);
		}
		reader.readAsDataURL(input.files[0]);
	}
}