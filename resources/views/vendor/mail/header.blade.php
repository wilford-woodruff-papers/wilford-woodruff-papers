<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://nyc3.digitaloceanspaces.com/wilford-woodruff-papers/img/gold-logo-square.gif" width="130" class="logo" alt="Wilford Woodruff Papers Foundation Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
