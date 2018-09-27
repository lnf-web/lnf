<div class="event-list">
    <h3>Current Events</h3>
    <?php if ($events): ?>
    <?php foreach ($events as $e): ?>
    <div class="event-list-item">
        <div><strong><a href="?event=<?=urlencode($e->slug)?>"><?=$e->name?></a></strong></div>
        <table>
            <tbody>
                <tr>
                    <td style="text-align: right; font-weight: bold; padding-left: 20px;">Date</td>
                    <td><?=date('n/j/Y', strtotime( $e->event_date))?></td>
                </tr>
                <tr>
                    <td style="text-align: right; font-weight: bold; padding-left: 20px;">Deadline</td>
                    <td><?=date('n/j/Y', strtotime($e->deadline))?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php endforeach; ?>
    <?php else: ?>
    No events were found.
    <?php endif; ?>
</div>