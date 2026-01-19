<div>
    <div class="" style="height:40px;width:40px;overflow: hidden;position:relative;margin: auto">
        <img alt="{{ $player->name }}" src="{{ $player->fileUrl }}" class="rounded img-fluid img-thumbnail table-img">
        <input type="file" wire:model.live="img" style="width:100%;height:100%;position:absolute;top:0;z-index: 1;left:0;opacity: 0" />
    </div>
</div>
