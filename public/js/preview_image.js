//PREVIEW DA IMAGEM DA CAPA DO LIVRO E DA IMAGEM DA CONTA
const inputImage = document.querySelector("[data-input-image]")//input da imagem
const inputImageConta = document.querySelector("[data-input-image-conta]")//input da imagem da conta
const labelImage = document.querySelector("[data-label-image]")//label da imagem
const previewImage = document.querySelector("[data-image-preview]")//imagem onde vai mostrar

//imagem do livro
if(inputImage){
    inputImage.onchange = () => {
        const [file] = inputImage.files;
        previewImage.src = URL.createObjectURL(file);
    }
}

//imagem da conta
if(inputImageConta){
    inputImageConta.onchange = () => {
        const [file] = inputImageConta.files;
        inputImageConta.style.backgroundImage = "url('" + URL.createObjectURL(file) + "')";
    }
}