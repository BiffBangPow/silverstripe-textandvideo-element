<div class="container">
    <div class="row<% if $VideoFirst %> order-last<% end_if %>">
        <div class="py-4 textvideo-text col-12 col-lg flex-lg-grow">
            <div class="text">
                <% if $ShowTitle %>
                    <h3 class="mb-4 title">$Title</h3>
                <% end_if %>
                <div>$Content</div>
                <% if $CTAType != 'None' %>
                    <div class="cta">
                        <p>
                            <a href="$CTALink" class="cta-link btn btn-secondary"
                                <% if $CTAType == 'External' %>target="_blank" rel="noopener"
                                <% else_if $CTAType == 'Download' %>download
                                <% end_if %>>
                                $LinkText
                            </a>
                        </p>
                    </div>
                <% end_if %>
            </div>
        </div>
        <div class="textvideo-video col-12 $VideoWidthClass">
            <div class="ratio ratio-16x9">
                <% if $VideoType == 'youtube' %>
                    <iframe title="$Title" class="video w-100 m-lg-auto" type="text/html"
                            src="https://www.youtube.com/embed/$VideoID"
                            allowFullScreen loading="lazy"></iframe>
                <% end_if %>
                <% if $VideoType == 'vimeo' %>
                    <iframe title="vimeo-player" class="video w-100 m-lg-auto"
                            src="https://player.vimeo.com/video/$VideoID" allowfullscreen loading="lazy"></iframe>
                <% end_if %>
            </div>
        </div>
    </div>
</div>