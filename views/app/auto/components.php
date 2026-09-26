<?php
class Component{
    static function service_card(string $icon, string $title, string $subtitle, array $items = []){
        ?>
        <div class="col-md-6 col-lg-4">
          <div class="service-card p-4 h-100">
            <div class="service-icon mb-3"><i class="fas <?=$icon?>"></i></div>
            <h4 class="fw-bold"><?= $title ?></h4>
            <p class="text-secondary"><?= $subtitle ?></p>
            <ul class="list-unstyled small text-secondary">
                <?php foreach($items as $k=>$v): ?>
                    <li><i class="fas fa-check text-primary me-2"></i><?= $v ?></li>
                <?php endforeach; ?>
            </ul>
          </div>
        </div>
        <?php
    }


    static function work_card($number, $title, $description){
        ?>
        <div class="col-md-3">
          <div class="process-step">
            <div class="d-flex align-items-center mb-2">
              <span class="step-number"><?= $number ?></span>
              <span class="fw-bold"><?= $title ?></span>
            </div>
            <p class="text-secondary small"><?= $description ?></p>
          </div>
        </div>
        <?php
    }
}