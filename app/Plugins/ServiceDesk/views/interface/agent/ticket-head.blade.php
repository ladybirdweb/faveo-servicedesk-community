<?php 
    $ticket = \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::getTicketByThreadId($id);
    $problem = $ticket->getTicketRelation('sd_problem');
    $asset = $ticket->getTicketRelation('sd_asset');
    $change = $ticket->getTicketRelation('sd_change');
    $ticketid = $ticket->id;
    
    ?>
<tr>
    
    @if(!$asset)
    
    <td>
        @include("service::interface.agent.popup.add-asset-one")
    </td>
    @else 
    <?php 
    Event::listen('ticket.timeline.marble',function()use($asset,$ticketid){
        $asset_controller = new App\Plugins\ServiceDesk\Controllers\Assets\AssetController();
        $asset_controller->timelineMarble($asset,$ticketid);
    }); 
    ?>
    @endif
    @if(!$problem)
    <td>
        @include("service::interface.agent.popup.add-problem")
        <!--<a href="" class="btn btn-sm btn-primary">Attach Problem</a>-->
    </td>
    @else 
    <?php 
    Event::listen('ticket.timeline.marble',function()use($ticketid,$problem){
        $problem_controller = new App\Plugins\ServiceDesk\Controllers\Problem\ProblemController();
        $problem_controller->timelineMarble($problem,$ticketid);
    }); 
    ?>
    @endif
    
</tr>