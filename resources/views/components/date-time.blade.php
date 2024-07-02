<p class="text-success mb-0">{{date_time($created)}}</p>
<p class="text-theme">{{$created != $updated ? date_time($updated) : __('Not updated')}}</p>
