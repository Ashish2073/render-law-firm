 <style>
     .top-right-button {
         position: absolute;
         top: 10px;
         right: 10px;
     }

     .profile-image-card,
     .form-card {
         background-color: #fff;
         border-radius: 10px;
         box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
         padding: 20px;
         margin: 10px;
         width: 100%;
         max-width: 400px;
     }

     .profile-image-card {
         flex: 1 1 30%;
         text-align: center;
     }



     .profile-image-card input {
         display: block;
         margin: 10px auto;
     }

     .form-cards {
         flex: 1 1 60%;
         display: flex;
         flex-direction: column;
         align-items: flex-start;
     }

     .form-card {
         margin-bottom: 20px;
     }

     h2 {
         margin-top: 0;
     }

     .form-group {
         margin-top: 10px;
     }

     label {
         display: block;
         margin-bottom: 5px;
     }

     input,
     textarea {
         width: 100%;
         padding: 10px;
         font-size: 16px;
         margin-top: 5px;
         box-sizing: border-box;
     }

     button {
         background-color: #4CAF50;
         color: white;
         border: none;
         cursor: pointer;
         padding: 10px 20px;
         font-size: 16px;
         align-self: flex-end;
     }

     button:hover {
         background-color: #45a049;
     }

     /* General Styles */

     * {
         box-sizing: border-box;
     }

     :root {
         --clr-white: rgb(255, 255, 255);
         --clr-black: rgb(0, 0, 0);
         --clr-light: rgb(245, 248, 255);
         --clr-light-gray: rgb(196, 195, 196);
         --clr-blue: rgb(63, 134, 255);
         --clr-light-blue: rgb(169,172,175);
     }

     .upload-area {
         width: 100%;
         /* max-width: 20rem; */
         background-color: var(--clr-white);
         /* box-shadow: 0 10px 60px rgb(218, 229, 255); */
         border: 1px solid var(--clr-light-blue);
         border-radius: 24px;
         padding: 2rem 1.875rem 5rem 1.875rem;
         margin: 0.625rem;
         text-align: center;
     }

     .upload-area--open {
         /* Slid Down Animation */
         animation: slidDown 500ms ease-in-out;
     }

     @keyframes slidDown {
         from {
             height: 28.125rem;
             /* 450px */
         }

         to {
             height: 35rem;
             /* 560px */
         }
     }

     /* Header */
     .upload-area__header {}

     .upload-area__title {
         font-size: 1.8rem;
         font-weight: 500;
         margin-bottom: 0.3125rem;
     }

     .upload-area__paragraph {
         font-size: 0.9375rem;
         color: var(--clr-light-gray);
         margin-top: 0;
     }

     .upload-area__tooltip {
         position: relative;
         color: var(--clr-light-blue);
         cursor: pointer;
         transition: color 300ms ease-in-out;
     }

     .upload-area__tooltip:hover {
         color: var(--clr-blue);
     }

     .upload-area__tooltip-data {
         position: absolute;
         top: 50%;
         left: 50%;
         transform: translate(-50%, -125%);
         min-width: max-content;
         background-color: var(--clr-white);
         color: var(--clr-blue);
         border: 1px solid var(--clr-light-blue);
         padding: 0.625rem 1.25rem;
         font-weight: 500;
         opacity: 0;
         visibility: hidden;
         transition: none 300ms ease-in-out;
         transition-property: opacity, visibility;
     }

     .upload-area__tooltip:hover .upload-area__tooltip-data {
         opacity: 1;
         visibility: visible;
     }

     /* Drop Zoon */
     .upload-area__drop-zoon {
         position: relative;
         height: 5.25rem;
         /* 180px */
         display: flex;
         justify-content: center;
         align-items: center;
         flex-direction: column;
         border: 2px dashed var(--clr-light-blue);
         border-radius: 15px;
         margin-top: 2.1875rem;
         cursor: pointer;
         transition: border-color 300ms ease-in-out;
     }

     .upload-area__drop-zoon:hover {
         border-color: var(--clr-blue);
     }

     .drop-zoon__icon {
         display: flex;
         font-size: 3.75rem;
         color: var(--clr-blue);
         transition: opacity 300ms ease-in-out;
     }

     .drop-zoon__paragraph {
         font-size: 0.9375rem;
         color: var(--clr-light-gray);
         margin: 0;
         margin-top: 0.625rem;
         transition: opacity 300ms ease-in-out;
     }

     .drop-zoon:hover .drop-zoon__icon,
     .drop-zoon:hover .drop-zoon__paragraph {
         opacity: 0.7;
     }

     .drop-zoon__loading-text {
         position: absolute;
         top: 50%;
         left: 50%;
         transform: translate(-50%, -50%);
         display: none;
         color: var(--clr-light-blue);
         z-index: 10;
     }

     .drop-zoon__preview-image {
         position: absolute;
         top: 0;
         left: 0;
         width: 100%;
         height: 100%;
         object-fit: contain;
         padding: 0.3125rem;
         border-radius: 10px;
         display: block;
         z-index: 1000;
         transition: opacity 300ms ease-in-out;
     }

     .drop-zoon:hover .drop-zoon__preview-image {
         opacity: 0.8;
     }

     .drop-zoon__file-input {
         display: none;
     }

     /* (drop-zoon--over) Modifier Class */
     .drop-zoon--over {
         border-color: var(--clr-blue);
     }

     .drop-zoon--over .drop-zoon__icon,
     .drop-zoon--over .drop-zoon__paragraph {
         opacity: 0.7;
     }

     /* (drop-zoon--over) Modifier Class */
     .drop-zoon--Uploaded {}

     .drop-zoon--Uploaded .drop-zoon__icon,
     .drop-zoon--Uploaded .drop-zoon__paragraph {
         display: none;
     }

     /* File Details Area */
     .upload-area__file-details {
         height: 0;
         visibility: hidden;
         opacity: 0;
         text-align: left;
         transition: none 500ms ease-in-out;
         transition-property: opacity, visibility;
         transition-delay: 500ms;
     }

     /* (duploaded-file--open) Modifier Class */
     .file-details--open {
         height: auto;
         visibility: visible;
         opacity: 1;
     }

     .file-details__title {
         font-size: 1.125rem;
         font-weight: 500;
         color: var(--clr-light-gray);
     }

     /* Uploaded File */
     .uploaded-file {
         display: flex;
         align-items: center;
         padding: 0.625rem 0;
         visibility: hidden;
         opacity: 0;
         transition: none 500ms ease-in-out;
         transition-property: visibility, opacity;
     }

     /* (duploaded-file--open) Modifier Class */
     .uploaded-file--open {
         visibility: visible;
         opacity: 1;
     }

     .uploaded-file__icon-container {
         position: relative;
         margin-right: 0.3125rem;
     }

     .uploaded-file__icon {
         font-size: 3.4375rem;
         color: var(--clr-blue);
     }

     .uploaded-file__icon-text {
         position: absolute;
         top: 1.5625rem;
         left: 50%;
         transform: translateX(-50%);
         font-size: 0.9375rem;
         font-weight: 500;
         color: var(--clr-white);
     }

     .uploaded-file__info {
         position: relative;
         top: -0.3125rem;
         width: 100%;
         display: flex;
         justify-content: space-between;
     }

     .uploaded-file__info::before,
     .uploaded-file__info::after {
         content: '';
         position: absolute;
         bottom: -0.9375rem;
         width: 0;
         height: 0.5rem;
         background-color: #ebf2ff;
         border-radius: 0.625rem;
     }

     .uploaded-file__info::before {
         width: 100%;
     }

     .uploaded-file__info::after {
         width: 100%;
         background-color: var(--clr-blue);
     }

     /* Progress Animation */
     .uploaded-file__info--active::after {
         animation: progressMove 800ms ease-in-out;
         animation-delay: 300ms;
     }

     @keyframes progressMove {
         from {
             width: 0%;
             background-color: transparent;
         }

         to {
             width: 100%;
             background-color: var(--clr-blue);
         }
     }

     .uploaded-file__name {
         width: 100%;
         max-width: 6.25rem;
         /* 100px */
         display: inline-block;
         font-size: 1rem;
         white-space: nowrap;
         overflow: hidden;
         text-overflow: ellipsis;
     }

     .uploaded-file__counter {
         font-size: 1rem;
         color: var(--clr-light-gray);
     }
 </style>

 <div id="{{ $uploadAreaId ?? 'uploadArea' }}" class="upload-area">

     <div class="upload-area__header">
         <h1 class="upload-area__title">{{$ImageUploadHeading ?? 'Lawyer Image'}}</h1>
         <p class="upload-area__paragraph">
             File should be an image
             <strong class="upload-area__tooltip">
                 Like
                 <span class="{{ $uploadareatooltipdata ?? 'upload-area__tooltip-data' }}"></span>

             </strong>
         </p>
     </div>

     <div id="{{ $dropZoomId ?? 'dropZoon' }}" class="upload-area__drop-zoon drop-zoon">
         <span class="drop-zoon__icon">
             <i class='bx bxs-file-image'></i>
         </span>
         <p class="drop-zoon__paragraph">Drop your file here or Click to browse</p>
         <span id="{{ $loadingTextId ?? 'loadingText' }}" class="drop-zoon__loading-text">Please Wait</span>
         <img src="{{ $imgsrc ?? asset('customer_image/defaultcustomer.jpg') }}" alt="Preview Image"
             id="{{ $previewImageId ?? 'previewImage' }}" class="drop-zoon__preview-image" draggable="false">
         <input type="file" id="{{ $fileInputId ?? 'fileInput' }}" name="{{ $fileInputName ?? 'profile_image' }}"
             class="drop-zoon__file-input" style="display:none;" accept="image/*">
     </div>

     <div id="{{ $fileDetailsId ?? 'fileDetails' }}" class="upload-area__file-details file-details">
         <h3 class="file-details__title">Uploaded File</h3>

         <div id="{{ $uploadedFileId ?? 'uploadedFile' }}" class="uploaded-file">
             <div class="uploaded-file__icon-container">
                 <i class='bx bxs-file-blank uploaded-file__icon'></i>
                 <span class="{{ $uploadedfileicontext ?? 'uploaded-file__icon-text' }}"></span>

             </div>

             <div id="{{ $uploadedFileInfoId ?? 'uploadedFileInfo' }}" class="uploaded-file__info">
                 <span class="{{ $uploadedfilenameClass ?? 'uploaded-file__name' }}">Proejct 1</span>
                 <span class="{{ $uploadedfilecounter ?? 'uploaded-file__counter' }}">0%</span>
             </div>
         </div>
     </div>

 </div>
 <script>
    

 

    

     function  imagePreveiewUpload(imageHtmlContentId) {

         const uploadArea = document.querySelector(`#${imageHtmlContentId.uploadAreaId}`);
         const dropZoon = document.querySelector(`#${imageHtmlContentId.dropZoomId}`);
         const loadingText = document.querySelector(`#${imageHtmlContentId.loadingTextId}`);
         const fileInput = document.querySelector(`#${imageHtmlContentId.fileInputId}`);
         const previewImage = document.querySelector(`#${imageHtmlContentId.previewImageId}`);
         const fileDetails = document.querySelector(`#${imageHtmlContentId.fileDetailsId}`);
         const uploadedFile = document.querySelector(`#${imageHtmlContentId.uploadedFileId}`);
         const uploadedFileInfo = document.querySelector(`#${imageHtmlContentId.uploadedFileInfoId}`);
         const uploadedFileName = document.querySelector('.uploaded-file__name');
         const uploadedFileIconText = document.querySelector('.uploaded-file__icon-text');
         const uploadedFileCounter = document.querySelector('.uploaded-file__counter');
         const toolTipData = document.querySelector('.upload-area__tooltip-data');

        

         const imagesTypes = ["jpeg", "png", "svg", "gif"];
         toolTipData.innerHTML = imagesTypes.map(type => `.${type}`).join(', ');

         dropZoon.addEventListener('dragover', function(event) {
             event.preventDefault();
             dropZoon.classList.add('drop-zoon--over');
         });

         dropZoon.addEventListener('dragleave', function() {
             dropZoon.classList.remove('drop-zoon--over');
         });

         dropZoon.addEventListener('drop', function(event) {
             event.preventDefault();
             dropZoon.classList.remove('drop-zoon--over');
             const file = event.dataTransfer.files[0];
             uploadFile(file);
         });

         dropZoon.addEventListener('click', function() {
             console.log('dsfsfsf', fileInput);
             fileInput.click();
         });


         fileInput.addEventListener('change', function(event) {
             const file = event.target.files[0];

             console.log('changesdsd', file)
             uploadFile(file);
             // event.target.value = '';
         });

         function uploadFile(file) {
             const fileReader = new FileReader();
             const fileType = file.type;
             const fileSize = file.size;

             if (fileValidate(fileType, fileSize)) {
                 dropZoon.classList.add('drop-zoon--Uploaded');
                 loadingText.style.display = "block";
                 previewImage.style.display = 'none';
                 uploadedFile.classList.remove('uploaded-file--open');
                 uploadedFileInfo.classList.remove('uploaded-file__info--active');

                 fileReader.addEventListener('load', function() {
                     setTimeout(function() {
                         uploadArea.classList.add('upload-area--open');
                         loadingText.style.display = "none";
                         previewImage.style.display = 'block';
                         fileDetails.classList.add('file-details--open');
                         uploadedFile.classList.add('uploaded-file--open');
                         uploadedFileInfo.classList.add('uploaded-file__info--active');
                     }, 500);

                   

                     previewImage.setAttribute('src', fileReader.result);
                     uploadedFileName.innerHTML = file.name;
                     progressMove();
                 });

                 fileReader.readAsDataURL(file);
             }
         }

         function progressMove() {
             let counter = 0;
             setTimeout(() => {
                 let counterIncrease = setInterval(() => {
                     if (counter === 100) {
                         clearInterval(counterIncrease);
                     } else {
                         counter += 10;
                         uploadedFileCounter.innerHTML = `${counter}%`;
                     }
                 }, 100);
             }, 600);
         }

         function fileValidate(fileType, fileSize) {
             const isImage = imagesTypes.find(type => fileType.includes(`image/${type}`));

             console.log(isImage);

             if (isImage) {
                 uploadedFileIconText.innerHTML = isImage === 'jpeg' ? 'jpg' : isImage;
                 if (fileSize <= 2000000) { // 2MB limit
                     return true;
                 } else {
                     alert('Please ensure your file is 2 Megabytes or less');
                     return false;
                 }
             } else {
                 alert('Please upload a valid image file');
                 return false;
             }
         }
     }
 </script>
