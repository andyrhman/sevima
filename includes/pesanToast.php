    
<?php if (isset($_SESSION['pesan'])) {
  ?>
  <div class="utama">
      <div class="pemanggang">
        <div class="konten">
          <div class="ikon"><i class="fa-solid fa-check"></i></div>
          <div class="detail">
            <span>Berhasil</span>
            <p><?= $_SESSION['pesan'];?></p>
          </div>
        </div>
        <div class="close-ikon"><i class="fa-solid fa-xmark"></i></div>
      </div>
  </div>
  <script>
    // Selecting all required elements
    const utama = document.querySelector(".utama"),
    pemanggang = utama.querySelector(".pemanggang"),
    title = pemanggang.querySelector("span"),
    subTitle = pemanggang.querySelector("p"),
    wifiIcon = pemanggang.querySelector(".ikon"),
    closeIcon = pemanggang.querySelector(".close-ikon");
    
    window.onload = ()=>{
        closeIcon.onclick = ()=>{ //hide toast notification on close icon click
            utama.classList.add("hide");
        }
        setTimeout(()=>{ //hide the toast notification automatically after 5 seconds
            utama.classList.add("hide");
        }, 5000);
    }
  </script>
  <?php
  unset($_SESSION['pesan']);
} 
?>

<?php if (isset($_SESSION['pesanError'])) {

  ?>
  <div class="utama-error" id="pemanggangError" style="display:block;">
      <div class="pemanggang-error">
          <div class="konten-error">
              <div class="ikon-error"><i class="fa-solid fa-xmark"></i></div>
              <div class="detail">
                <span>Error</span>
                <p><?= $_SESSION['pesanError'];?></p>
              </div>
          </div>
          <div class="close-ikon-error"><i class="fa-solid fa-xmark"></i></div>
          <!-- <div class="close-ikon-error"><i class="fa-solid fa-xmark"></i></div> -->
      </div>
  </div>
  <script>
      // Selecting all required elements
      const utamaError = document.querySelector(".utama-error"),
      pemanggangError = utamaError.querySelector(".pemanggang-error"),
      titleError = pemanggangError.querySelector("span"),
      subTitleError = pemanggangError.querySelector("p"),
      wifiIconError = pemanggangError.querySelector(".ikon-error"),
      closeIconError = pemanggangError.querySelector(".close-ikon-error");
      
      window.onload = ()=>{
          closeIconError.onclick = ()=>{ //hide toast notification on close icon click
              utamaError.classList.add("hide");
          }
          setTimeout(()=>{ //hide the toast notification automatically after 5 seconds
              utamaError.classList.add("hide");
          }, 5000);
      }
  </script>
  <?php
  unset($_SESSION['pesanError']);
} 
?>
