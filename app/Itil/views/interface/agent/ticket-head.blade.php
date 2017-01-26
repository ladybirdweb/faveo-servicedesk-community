<?php
$ticket = \App\Itil\Controllers\UtilityController::getTicketByThreadId($id);
$problem = $ticket->getTicketRelation('sd_problem');
if (isAsset() == true) {
    $asset = $ticket->getTicketRelation('sd_asset');
}
$change = $ticket->getTicketRelation('sd_change');
$ticketid = $ticket->id;
?>
<tr>
    @if(isAsset() == true)
    @if(!$asset)

    <td>
        @include("itil::interface.agent.popup.add-asset-one")
    </td>
    @else 
    <?php
    Event::listen('ticket.timeline.marble', function()use($asset, $ticketid) {
        $asset_controller = new App\Itil\Controllers\Assets\AssetController();
        $asset_controller->timelineMarble($asset, $ticketid);
    });
    ?>
    @endif
    @endif
    @if(!$problem)
    <td>
        @include("itil::interface.agent.popup.add-problem")
        <!--<a href="" class="btn btn-sm btn-primary">Attach Problem</a>-->
    </td>
    @else 
    <?php
    Event::listen('ticket.timeline.marble', function()use($ticketid, $problem) {
        $problem_controller = new App\Itil\Controllers\ProblemController();
        $problem_controller->timelineMarble($problem, $ticketid);
    });
    ?>
    @endif

</tr>