<div class="event-form">
    <?php if ($event): ?>
    <form method="post">
        <div class="event-header">
            <div class="event-title"><?=$event->title?></div>
            <?php if ($e->subtitle): ?>
            <div class="event-subtitle"><?=$event->subtitle?></div>
            <?php endif; ?>
        </div>
        <table class="event-fields">
            <tbody>
                <?php foreach($fields as $f): ?>
                <tr data-id="<?=$f->id?>" data-type="<?=$f->type?>" data-required="<?=($f->required?"true":"false")?>">
                    <?php /* first  column */ ?>
                    <?php if (in_array($f->type, array('text', 'textarea', 'select', 'release'))): ?>
                    <td class="field-name"><?=$f->name?></td>
                    <?php elseif ($f->type == 'label'): ?>
                    <td class="label-text" colspan="2"><?=$f->text?></td>
                    <?php else: ?>
                    <td class="error" colspan="2">Unknown field type: <?=$f->type?></td>
                    <?php endif; ?>
                    
                    <?php /* second  column */ ?>
                    <?php if ($f->type == 'text'): ?>
                    <td class="field-input">
                        <input type="text" id="<?=$f->id?>" name="<?=$f->id?>" class="field-value" value="<?=$f->value?>" style="width: <?=$f->width?>;">
                    </td>
                    <?php elseif ($f->type == 'textarea'): ?>
                    <td class="field-input">
                        <textarea id="<?=$f->id?>" name="<?=$f->id?>" class="field-value" style="width: <?=$f->width?>; height: 80px;"><?=$f->value?></textarea>
                    </td>
                    <?php elseif ($f->type == 'select'): ?>
                    <td class="field-input">
                        <select id="<?=$f->id?>" name="<?=$f->id?>" class="field-value" style="width: <?=$f->width?>;">
                            <option value="">-- Select --</option>
                            <?php foreach ($f->items as $i): ?>
                            <option value="<?=$i->value?>"<?=($i->value == $f->value?' selected':'')?>><?=$i->text?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <?php elseif ($f->type == 'release'): ?>
                    <td class="field-input">
                        <div class="release-text"><?=$f->text?></div>
                        <label>
                            <input type="checkbox" id="<?=$f->id?>" name="<?=$f->id?>" class="field-value"<?=($f->value?' checked':'')?>> Accept
                        </label>
                    </td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="event-footer">
            <button type="submit" class="submit" name="SubmitForm" value="1">Submit</button>
            <div class="errors">
                <?php if (count($errors) > 0): ?>
                <ul>
                    <?php foreach ($errors as $err): ?>
                    <li class="error"><?=$err?></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>
        </div>
    </form>
    <?php else: ?>
    <span class="error">Event not found.</span>
    <?php endif; ?>
</div>

