<?php

use Concrete\Core\Page\Page;
use Concrete\Core\Support\Facade\Url;

defined('C5_EXECUTE') or die('Access denied');

?>

<div class="pricing-slider">

    <div class="pricing-banner-wrapper">
        <h1 class="text-center">
            <?php echo t("Predictable Pricing. No Surprises."); ?>
        </h1>

        <div>
            <p class="text-center">
                <?php echo t("Choose the number of active talents working on your requests at the same time:"); ?>
            </p>
        </div>

        <div class="progress-bar-wrapper">
            <?php foreach($items as $item) { ?>
                <div class="circle-wrapper circle-<?php echo $item["taskNumber"]; ?> <?php echo ((int)$activeTaskNumber === (int)$item["taskNumber"] ? "active" : ""); ?>">
                    <div class="pulse pulse1"></div>
                    <div class="pulse pulse2"></div>
                    <div class="circle circle-<?php echo $item["taskNumber"]; ?>"></div>

                    <div class="circle-text">
                        <?php echo $item["taskNumber"]; ?>
                    </div>

                    <a href="javascript:void(0);" data-task-number="<?php echo $item["taskNumber"]; ?>" class="circle-link"></a>
                </div>
            <?php } ?>
        
            <div class="line"></div>

            <div class="line blue"></div>

            <div class="price-arrow-wrapper">
                
                <div class="price-arrow">
                    <svg width="74" height="35" viewBox="0 0 74 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.91446 3.43074C20.402 15.4016 44.1751 23.0185 66.5056 22.1239" stroke="var(--bs-primary)" stroke-width="3" stroke-linecap="round"/>
                        <path d="M56.6604 11.8778C61.2115 18.0512 66.9825 22.1046 72.3194 21.8908" stroke="var(--bs-primary)" stroke-width="3" stroke-linecap="round"/>
                        <path d="M57.5115 33.1244C61.5542 26.6067 66.9825 22.1046 72.3194 21.8908" stroke="var(--bs-primary)" stroke-width="3" stroke-linecap="round"/>
                    </svg>
                </div>

                <p class="price-arrow-text">
                    <?php echo t("Scale up and down"); ?>
                </p>
            </div>
        </div>
    </div>

    <?php foreach($items as $item) { ?>
        <div data-task-number="<?php echo $item["taskNumber"]; ?>" class="infobox bg-light <?php echo ((int)$activeTaskNumber !== (int)$item["taskNumber"] ? "d-none" : ""); ?>">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-sm-12">
                        <h2>
                            <?php echo t("All Inclusive"); ?>
                        </h2>

                        <p>
                            <?php echo t("For fast-moving agencies, marketing teams & scale-ups who need access to reliable on-demand design & dev talents to move even faster."); ?>
                        </p>
                    </div>
                </div>

                <div class="row flex-row">
                    <div class="col-md-4 col-sm-12">
                        <ul class="features">
                            <li>
                                <?php echo t("Unlimited Design Requests"); ?>
                            </li>

                            <li>
                                <?php echo t("Unlimited Development Requests"); ?>
                            </li>

                            <li>
                                <?php echo t("Unlimited Revisions"); ?>
                            </li>

                            <li>
                                <?php echo t("Unlimited Brands"); ?>
                            </li>
                        </ul>
                    </div>

                    <div class="col-md-4 col-sm-12">
                        <ul class="features">
                            <li>
                                <?php echo t("Dedicated Project Manager"); ?>
                            </li>

                            <li>
                                <?php echo t("Daily Updates & Progress Reports"); ?>
                            </li>

                            <li>
                                <?php echo t("Pause or Cancel Anytime"); ?>
                            </li>

                            <li>
                                <?php echo t("Upgrade or Downgrade Anytime"); ?>
                            </li>
                        </ul>
                    </div>

                    <div class="col-md-4 col-sm-12">
                        <h3 class="price-per-month">
                            <?php echo sprintf("$%s/m", number_format($item["price"])); ?>
                        </h3>

                        <a href="<?php echo Url::to(Page::getByID($targetPage)); ?>" class="btn btn-primary">
                            <?php echo t("Subscribe Now"); ?>
                        </a>

                        <p class="text-muted">
                            <?php echo t("100% Satisfaction Guarantee"); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<script>
    (function ($) {
        $(function(){
            $(".pricing-slider .circle-link").click(function(e) {
               e.preventDefault();
               e.stopPropagation();

               $(this).parent().parent().find(".circle-wrapper").removeClass("active");
               $(this).parent().addClass("active");

               var activeTaskNumber = $(this).data("taskNumber");

               $(this).parent().parent().parent().parent().find(".infobox").each(function() {
                   if (parseInt($(this).data("taskNumber")) === parseInt(activeTaskNumber)) {
                        $(this).removeClass("d-none");
                   } else {
                        $(this).addClass("d-none");
                   }
               });
               
               return false;
            });
        });
    })(jQuery);
</script>

<style type="text/css">
.infobox {
    margin-top: 80px;
}

.infobox .text-muted {
    font-size: 1rem;
    margin-top: 5px;
}

.flex-row {
    display: flex;
    align-items: center;
    justify-content: center;
}

ul.features {
    list-style: none;
    margin: 0;
    padding: 0;
}

ul.features li {
    list-style: none;
    margin: 0;
    padding: 0;
}

.pulse {
    width: 10px;
    height: 10px;
    border: 2px solid var(--bs-primary);
    border-radius: 100%;
    position: absolute;
    top: auto;
    bottom: auto;
    left: auto;
    right: auto;
}

.circle-text {
    padding-top: 15px;
    font-size: 16px;
    line-height: 1.2em;
    position: absolute;
    top: 15px;
}

.circle-wrapper {
    z-index: 3;
    width: 15px;
    height: 15px;
    cursor: pointer;
    justify-content: center;
    align-items: center;
    display: flex;
    position: relative;
}

.circle-wrapper.circle-2.is-circle-2 {
    position: relative;
    bottom: 0%;
    right: 0%;
}

.progress-bar-wrapper {
    grid-column-gap: 10px;
    flex-wrap: nowrap;
    justify-content: space-between;
    align-items: center;
    margin-top: 70px;
    display: flex;
    position: relative;
}

.pricing-banner-wrapper {
    width: 100%;
    max-width: 685px;
    margin-top: 132px;
    margin-left: auto;
    margin-right: auto;
}

.line {
    z-index: 1;
    width: 100%;
    height: 3px;
    background-color: var(--bs-gray-200);
    position: absolute;
}

.price-arrow-wrapper {
    width: 100%;
    max-width: 90px;
    position: absolute;
    bottom: 27px;
    left: -130px;
}

.price-arrow {
    width: 100%;
    max-width: 60px;
    display: block;
    position: absolute;
    bottom: -31px;
    right: -10px;
}

.price-arrow-text {
    color: var(--bs-primary);
    font-size: 18px;
    font-weight: 600;
    line-height: 112%;
}

.circle {
    z-index: 2;
    width: 15px;
    height: 15px;
    background-color: var(--bs-gray-200);
    border: 2px solid #fff;
    border-radius: 100%;
    justify-content: center;
    align-items: center;
    display: flex;
    position: relative;
}

.circle-wrapper.active .circle {
    background-color: var(--bs-primary);
}

.circle-link {
    z-index: 5;
    width: 100%;
    height: 100%;
    max-width: 100%;
    position: absolute;
    top: 0%;
    bottom: 0%;
    left: 0%;
    right: 0%;
    background-color: rgba(0, 0, 0, 0);
}

@media screen and (max-width: 991px) {
    .price-arrow {
        display: none;
    }

    .price-arrow-text {
        display: none;
    }

    .infobox .flex-row > div {
        margin-bottom: 20px;
    }
}

.circle-wrapper.active .pulse1 {
    -webkit-animation: pulse 2s linear infinite;
    -moz-animation: pulse 2s linear infinite;
    -o-animation: pulse 2s linear infinite;
    animation: pulse 2s linear infinite;
}

.circle-wrapper.active .pulse2 {
    -webkit-animation: pulse 2s linear infinite;
    -moz-animation: pulse 2s linear infinite;
    -o-animation: pulse 2s linear infinite;
    animation: pulse 2s linear infinite;
    -webkit-animation-delay: 1s;
    -moz-animation-delay: 1s;
    -o-animation-delay: 1s;
    animation-delay: 1s;
}

@-webkit-keyframes pulse {
    0% {
        width: 10px;
        height: 10px;
    }

    50% {
        opacity: 100%
    }

    100% {
        width: 45px;
        height: 45px;
        opacity: 0%;
    }
}

@-moz-keyframes pulse {
    0% {
        width: 10px;
        height: 10px;
    }

    50% {
        opacity: 100%
    }

    100% {
        width: 45px;
        height: 45px;
        opacity: 0%;
    }
}

@-o-keyframes pulse {
    0% {
        width: 10px;
        height: 10px;
    }

    50% {
        opacity: 100%
    }

    100% {
        width: 45px;
        height: 45px;
        opacity: 0%;
    }
}

@keyframes pulse {
    0% {
        width: 10px;
        height: 10px;
    }

    50% {
        opacity: 100%
    }

    100% {
    width: 45px;
    height: 45px;
    opacity: 0%;    
    }
}
</style>