<!--Modal for displaying subject quick view-->
<div class="hidden bg-primary border-0 mb-3 block z-50 font-normal leading-normal text-sm max-w-sm text-left no-underline break-words rounded-lg" id="popover-id">
    <div>
        <div id="title" class="bg-primary text-white font-medium p-3 mb-0 border-b border-solid border-gray-200 uppercase">

        </div>
        <div id="content" class="text-white p-3 max-h-60 overflow-y-scroll">

        </div>
        <div class="md:flex-1 md:flex md:items-center md:justify-between border-t border-solid border-gray-200 uppercase">
            <div id="link" class="bg-primary text-white font-medium p-3 mb-0">
                <a class="px-4 py-1 border border-secondary text-xs font-medium text-white bg-secondary hover:text-highlight cursor-pointer"
                   id="page-link"
                   href="#"
                >
                    View More
                </a>
            </div>
            <div id="link" class="bg-primary p-3 mb-0">
                <div id="close-popup"
                     class="px-4 py-1 border border-gray-400 text-xs font-medium text-primary bg-gray-300 hover:text-secondary cursor-pointer">
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
                        window.location = $subject.attr('href');
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
