<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
FireWall();
header("Content-type: text/xml");
// if (get_total('ads', "WHERE position_name = 'vast_mp4' AND type = 'true'") < 1) die();
$ads = GetDataArr('ads', "position_name = 'vast_mp4'");
?>
<VAST version="2.0">
    <Ad id="preroll-1">
        <InLine>
            <AdSystem>2.0</AdSystem>
            <AdTitle>sbbanner</AdTitle>
            <Impression id="sbbanner">
                <![CDATA[]]>
            </Impression>
            <Creatives>
                <Creative>
                    <Linear>
                        <Duration>00:01:13</Duration>
                        <TrackingEvents>
                        </TrackingEvents>
                        <VideoClicks>
                            <ClickThrough id="scanscout">
                                <![CDATA[<?= $cf['vast_link'] ?>]]>
                            </ClickThrough>
                        </VideoClicks>
                        <MediaFiles>
                            <MediaFile height="400" width="650" bitrate="1000" type="video/mp4" delivery="progressive">
                                <![CDATA[<?= $cf['vast_video'] ?>]]>
                            </MediaFile>
                        </MediaFiles>
                    </Linear>
                </Creative>
                <Creative>
                    <CompanionAds>
                        <Companion height="250" width="300" id="555750">
                            <HTMLResource>
                                <![CDATA[]]>
                            </HTMLResource>
                        </Companion>
                    </CompanionAds>
                </Creative>
            </Creatives>
        </InLine>
    </Ad>
</VAST>