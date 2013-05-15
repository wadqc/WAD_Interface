<?php

$i_max=24;
$j=0;
$value="Meetwaarde";

printf("kritischboven \t acceptabelboven \t %s \t acceptabelonder \t kritischonder \n",$value);         //name 
printf("Red \t Orange \t Blue \t Orange \t Red \n");                                                          //color
printf("ShortDot\tShortDot\tSolid\tShortDot\tShortDot\n");                                    //dashstyle
//printf("Solid\tSolid\tSolid\tSolid\tSolid\n"); 
printf("0 \t 0 \t 0 \t 0 \t 0 \n");                                    //marker
printf("diamond\ttriangle\tcircle\ttriangle-down\tdiamond\n"); //symbol

While ($j<$i_max)
{
//printf("Friday, July 1, 2011 %d:00:00 \t %d \n",$j,pow($j,2));
//printf("2012-04-13 %d:00:00",$j);
$tijd=strtotime(sprintf("2011-07-01 %d:00:00 UTC",$j));

printf("%s \t %s \t %s \t %s \t %s \t %s \n",$tijd,5*$j+0.1,4*$j+0.2,3*$j+0.3,2*$j+0.4,1*$j+0.5);
//printf("Friday, July 1, 2011 %d:00:00 \t %s \t %s \t %s \t %s \t %s \n",$j,5*$j,4*$j,3*$j,2*$j,1*$j);
$j++;
}
//2012-04-11 07:51:34



?> 