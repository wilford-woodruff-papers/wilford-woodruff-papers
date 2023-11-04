<!--Modal for displaying subject quick view-->
<div class="block hidden z-50 mb-3 max-w-sm text-sm font-normal leading-normal text-left no-underline break-words rounded-lg border-0 bg-primary" id="popover-id">
    <div>
        <div id="title" class="p-3 mb-0 font-medium text-white uppercase border-b border-gray-200 border-solid bg-primary">

        </div>
        <div id="content" class="overflow-y-scroll p-3 max-h-60 text-white">

        </div>
        <div class="uppercase border-t border-gray-200 border-solid md:flex md:flex-1 md:justify-between md:items-center">
            <div id="link" class="p-3 mb-0 font-medium text-white bg-primary">
                <a class="py-1 px-4 text-xs font-medium text-white border cursor-pointer border-secondary bg-secondary hover:text-highlight"
                   id="page-link"
                   href="#"
                   target="_blank"
                >
                    View More
                </a>
            </div>
            <div id="link" class="p-3 mb-0 bg-primary">
                <div id="close-popup"
                     class="py-1 px-4 text-xs font-medium bg-gray-300 border border-gray-400 cursor-pointer text-primary hover:text-secondary">
                    Close
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
        $(document).on('click', '.popup', function(e){
            e.preventDefault();
            var $subject = $(this);
            $.ajax({
                url: $subject.attr('href'),
                success: function(data){
                    if(data.bio === null || data.bio.length < 1){
                        // No information has been added, redirect to view related media
                        window.open($subject.attr('href'), "_blank");
                    }else{
                        // Show page description
                        $('#popover-id #title').html(data.name);
                        $('#popover-id #content').html(data.bio);
                        $('#popover-id a#page-link').attr('href', $subject.attr('href'));
                        openPopover(e, 'popover-id');
                    }
                },
                error: function (){
                    // A page has not been created yet
                    $('#popover-id #title').html($subject.attr('title'));
                    $('#popover-id #content').html('Coming soon.');
                    openPopover(e, 'popover-id');
                }
            });
        });

        $(document).click(function(e){
            $('#popover-id').addClass("hidden");
        });

        $('#close-popup').click(function(e){
            $('#popover-id').addClass("hidden");
        });

        function openPopover(event,popoverID){
            let element = event.target;
            /*while(element.nodeName !== "BUTTON"){
                element = element.parentNode;
            }*/
            var popper = new Popper(element, document.getElementById(popoverID), {
                placement: 'top'
            });
            $('#popover-id').removeClass("hidden");
        }
    });
</script>
