<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\PDOX;
use \Tsugi\Util\U;
use \Tsugi\Util\Mersenne_Twister;

// Called first
function ccauto_instructions($LAUNCH) { return <<< EOF
<b>Exercise cc-2-5:</b> Write a C program to implement
this Python program, using the <b>fgets</b> function instead of <b>scanf</b>.
<pre>
print('Enter line')
line = input()
print('Line:', line)
</pre>
EOF
;
}

function ccauto_input($LAUNCH) { return <<< EOF
Hello world - have a nice day
EOF
;
}

function ccauto_solution($LAUNCH) { return <<< EOF
#include <stdio.h>
int main() {
    char line[1000];
    printf("Enter line\\n");
    fgets(line, 1000, stdin);
    printf("Line: %s\\n", line);
}
EOF
;
}

function ccauto_output($LAUNCH) { return <<< EOF
Enter line
Line: Hello world - have a nice day
EOF
;
}

function ccauto_sample($LAUNCH) {  return <<< EOF
#include <stdio.h>
int main() {
    printf("Hello world\\n");
}
EOF
;
} 

function ccauto_main($LAUNCH) { return false; }
function ccauto_prohibit($LAUNCH) { 
    return array(
        array('nice', "'Nice' try - please read the data from input..."),
    );
}
function ccauto_require($LAUNCH) { 
    return array(
        array('fgets', 'You should use the fgets() function in the solution to this problem.'),
    );
}

