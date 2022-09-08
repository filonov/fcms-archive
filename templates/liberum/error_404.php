<? require_once 'inc_header.php'; ?>
<? require_once 'inc_menu.php'; ?>
<div class="content">
    <div class="container">
        <div class="row">
            <div class="span12">
                <div class="error">
                    <div class="row">
                        <div class="span12">
                            <div class="error-page">
                                <p class="error-med">Oops! Чего-то не хватает.</p>                        
                                <p class="error-big">404<span class="color">!!!</span></p>                        
                                <p class="error-small">Страница, которую вы искали, отсутствует.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cta">
                    <div class="row">
                        <div class="span12">
                            <!-- First line -->
                            <p class="cbig">Что делать?</p>
                            <!-- Second line -->
                            <p class="csmall">
                                <?= block_module('tekst-stranitsi-404') ?>
                            </p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="span12">
                            <form method="post" id="searchform" action="{base}search" class="form-search">
                                <div class="input-append">
                                    <input type="text" value="" name="searchstr" id="s" class="input-xxlarge search-query"/>
                                    <button type="submit" class="btn">Искать</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>   
<? require 'inc_footer.php'; ?>