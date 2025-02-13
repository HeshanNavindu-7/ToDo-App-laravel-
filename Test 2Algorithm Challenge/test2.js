// Reverse a String
function reverseString(str) {
    return str.split('').reverse().join('');
}


console.log(reverseString("hello"));



//  Find the Second-Largest Number in an Array
function secondLargest(arr) {
    if (arr.length < 2) {
        return "Array must have at least two numbers.";
    }

    let first = -Infinity, second = -Infinity;

    for (let num of arr) {
        if (num > first) {
            second = first;
            first = num;
        } else if (num > second && num < first) {
            second = num;
        }
    }

    return second !== -Infinity ? second : "No second largest number found.";
}


console.log(secondLargest([10, 20, 4, 45, 99]));



// Check if a String is a Palindrome
function isPalindrome(str) {
    let cleanedStr = str.toLowerCase().replace(/[^a-z0-9]/g, '');
    let reversedStr = cleanedStr.split('').reverse().join('');
    return cleanedStr === reversedStr;
}


console.log(isPalindrome("racecar"));
console.log(isPalindrome("hello"));
console.log(isPalindrome("A man, a plan, a canal, Panama"));
