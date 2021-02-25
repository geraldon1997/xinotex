<?php
use App\Models\User;
use App\Models\Investment;
use App\Models\Withdrawal;
use App\Controllers\Investment as Cinvest;

$inv = new Cinvest;
?>

<?php if (User::isAdmin()) : ?>
<div class="row dash-row">
    <div class="col-xl-4">
        <div class="stats stats-primary">
            <h3 class="stats-title"> Total user(s) </h3>
            <div class="stats-content">
                <div class="stats-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stats-data">
                    <div class="stats-number"><?= count(User::all(User::$table)); ?></div>
                    <div class="stats-change">
                        <span class="stats-percentage">+25%</span>
                        <span class="stats-timeframe">from last month</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="stats stats-success ">
            <h3 class="stats-title"> Total Investment(s) </h3>
            <div class="stats-content">
                <div class="stats-icon">
                    <i class="fas fa-cube"></i>
                </div>
                <div class="stats-data">
                    <div class="stats-number"><?= count(Investment::all(Investment::$table)); ?></div>
                    <div class="stats-change">
                        <span class="stats-percentage">+17.5%</span>
                        <span class="stats-timeframe">from last month</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="stats stats-danger">
            <h3 class="stats-title"> Total Withdrawal(s) </h3>
            <div class="stats-content">
                <div class="stats-icon">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
                <div class="stats-data">
                    <div class="stats-number"><?= count(Withdrawal::all(Withdrawal::$table)); ?></div>
                    <div class="stats-change">
                        <span class="stats-percentage">+17.5%</span>
                        <span class="stats-timeframe">from last month</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php elseif (User::isMember() || User::isModerator()) : ?>
<!-------------------------------------------------------------------------------->
    <?php if (User::hasProfile()) : ?>
<!-------------------------------------------------------------------------------->
<div class="row dash-row">
    <div class="col-xl-4">
        <div class="stats stats-success ">
            <h3 class="stats-title"> Total Investment(s) </h3>
            <div class="stats-content">
                <div class="stats-icon">
                    <i class="fas fa-cube"></i>
                </div>
                <div class="stats-data">
                    <div class="stats-number"><?= Investment::total(); ?></div>
                    <div class="stats-change">
                        <span class="stats-percentage">+17.5%</span>
                        <span class="stats-timeframe">from last month</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="stats stats-primary ">
            <h3 class="stats-title"> Current Investment </h3>
            <div class="stats-content">
                <div class="stats-icon">
                    <i class="fas fa-cube"></i>
                </div>
                <div class="stats-data">
                    <div class="stats-number"><?= Investment::current() ? '$'.number_format(Investment::current()[0]['amount']) : '0'; ?></div>
                    <div class="stats-change">
                        <span class="stats-percentage" id="roi"><?= Investment::current() ? '$'.number_format(Investment::current()[0]['expected_amount']) : '0' ?></span>
                        <span class="stats-timeframe" id="topup">ROI</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="stats stats-danger">
            <h3 class="stats-title"> Total Withdrawal(s) </h3>
            <div class="stats-content">
                <div class="stats-icon">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
                <div class="stats-data">
                    <div class="stats-number"><?= Withdrawal::totalWithdrawal(); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
<script defer src="https://www.livecoinwatch.com/static/lcw-widget.js"></script> <div class="livecoinwatch-widget-5" lcw-base="USD" lcw-color-tx="#999999" lcw-marquee-1="coins" lcw-marquee-2="movers" lcw-marquee-items="10" ></div>
<hr>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive" data-pattern="priority-columns">
            <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
            <script type="text/javascript">
                new TradingView.widget({
                "width": '100%',
                "height": 610,
                "symbol": "BTCUSD",
                "interval": "1",
                "timezone": "Etc/UTC",
                "theme": "dark",
                "style": "4",
                "locale": "en",
                "toolbar_bg": "rgba(0, 0, 0, 1)",
                "enable_publishing": false,
                "allow_symbol_change": true,
                "hideideas": true,
                "news": [
                            "headlines"
                        ]
                });
                
            </script>
        </div>
    </div>
</div>
<input type="hidden" id="expected_amount" value="<?= Investment::current()[0]['expected_amount'] ?>">
<input type="hidden" id="maturity" value="<?= date('s', strtotime(Investment::current()[0]['period'])) ?>">

    <?php else : ?>
    <div class="alert alert-secondary" role="alert"> Please update your <a href="<?= PROFILE; ?>" class="btn btn-outline-primary">Profile</a> before you can proceed </div>
    <?php endif; ?>
<?php endif; ?>


