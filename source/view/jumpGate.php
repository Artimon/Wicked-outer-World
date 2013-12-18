<?php

/**
 * @var string $sectors
 * @var int $sectorId
 * @var int $money
 */

$setup = array($sectors, $sectorId, $money);
$setup = implode(',', $setup);
?>

<div id="jumpGate" ng-controller="JumpGateCtrl"
	 ng-init='setup(<?php echo $setup ?>)'>
	<h2>{{'jumpGate'|i18n}}</h2>
	<p>{{'jumpGateDescription'|i18n}}</p>

	<div class="planetInformation">
		<div class="box">
			<h3 class="header">{{'sector'|i18n}}</h3>
			<div class="content">
				<h4 class="highlight">{{sector.name|i18n}}</h4>
				<p>{{sector.description|i18n}}</p>
				<hr>
				<div ng-show="sector.isAvailable">
					<p class="headline">{{sector.starbase|i18n}}</p>
					<p class="variable">{{'availableModules'|i18n}}</p>
					<div ng-repeat="module in sector.modules">
						<span class="entypo-shareable"></span>
						{{module.name|i18n}}
						<span class="variable whatsThis" title="{{'level'|i18n}}"
							ng-show="module.level > 0">
							({{module.level}})
						</span>
					</div>
					<div ng-show="sector.key != currentSector.key">
						<hr>
						<p>
							<span class="highlight">{{'travelCost'|i18n}}</span>
							<span class="variable"
								  ng-class="{ critical: travelPrice > money }">
								{{travelPrice}} s£
							</span>
						</p>
						<div class="right clear">
							<button class="button"
									ng-class="{ disabled: travelPrice > money }"
									ng-click="travelTo(sector)">
								{{'engage'|i18n}}
							</button>
						</div>
					</div>
				</div>
				<div class="critical" ng-hide="sector.isAvailable">
					{{'noSectorInformation'|i18n}}
				</div>
			</div>
		</div>

		<div class="box" ng-hide="sector.isAvailable">
			<h3 class="header">{{'openGate'|i18n}}</h3>
			<div class="content">
				<p ng-class="{ critical: !sector.canAfford, bold: !sector.canAfford }">
					{{'openGateInfo'|i18n:sector.unlockPrice}}
				</p>
				<div class="right" ng-show="sector.canAfford">
					<button class="button" ng-click="unlockSector(sector)">
						{{'doIt'|i18n}}
					</button>
				</div>
			</div>
		</div>
	</div>

	<div class="starmap">
		<a href="javascript:;" class="sectorLink"
		   ng-repeat="sector in sectors"
		   ng-click="showInfo(sector)"
		   ng-class="{ selected: isSelected(sector.key), inactive: !sector.isAvailable }"
		   ng-style="{ left: sector.x, top: sector.y }">
			<span class="entypo-record"></span>
			{{sector.name|i18n}}
		</a>
	</div>

	<div class="clear"></div>
</div>