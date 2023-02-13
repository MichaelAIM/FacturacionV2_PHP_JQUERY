<div class="observaciones">  
  <div class="page">
    <div class="timeline">
    <?php
    if ($_POST['data']['obs'] != '') {
      setlocale(LC_TIME, 'spanish');  
      $dtFactura = $_POST['data']['obs'];
      for ($i=0; $i < count($dtFactura); $i++) {   
        $mes = strtoupper(strftime("%b", strtotime($dtFactura[$i]['created_at'])));      
        $dia = strftime("%d", strtotime($dtFactura[$i]['created_at']));
        if ($dtFactura[$i]['tipo_obs'] == 1) {
          $bgWrning = 'bg-warning';
          $brdWarning = 'brdWarning';
        }else{
          $bgWrning = "";
          $brdWarning = "";
        }
      ?>
        <div class="timeline__group">
          <div class="timeline__box">
            <div class="timeline__date <?php echo $bgWrning; ?>">
              <span class="timeline__day"><?=$dia;?></span>
              <span class="timeline__month"><?=$mes;?></span>
            </div>
            <div class="timeline__post <?php echo $brdWarning; ?>">
              <div class="timeline__content">
                <p><?=$dtFactura[$i]['detalle'];?></p>
                <p style="float: right;">- <?=$dtFactura[$i]['per_nombre'];?> -</p>                          
              </div>
            </div>
          </div>
        </div>
      <?php 
      }
    }
    ?>
    </div>
  </div>
</div>