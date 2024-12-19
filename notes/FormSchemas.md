# Types
## Kurzantwort
## Absatz
## Multiple Choice
## Checkbox
## Dropdown
## Date



```json
{
    "version": 1,
    "title": "TEST",
    "description": "TEST DESCRIPTION",
    "questions": [
        {
            "type": "short_answer",
            "title": "Short Question",
            "description": "Short Question Description",
            "required": true
        },
        {
            "type": "paragraph",
            "title": "Paragraph Question",
            "description": "Paragraph Question Description",
            "required": true
        },
        {
            "type": "multiple_choice",
            "title": "Multiple Choice Question",
            "description": "Multiple Choice Question Description",
            "required": true,
            "options": [
                "Option 1",
                "Option 2",
                "Option 3"
            ]
        },
        {
            "type": "checkbox",
            "title": "Checkbox Question",
            "description": "Checkbox Question Description",
            "required": true,
            "options": [
                "Option 1",
                "Option 2",
                "Option 3"
            ]
        },
        {
            "type": "dropdown",
            "title": "Dropdown Question",
            "description": "Dropdown Question Description",
            "required": true,
            "options": [
                "Option 1",
                "Option 2",
                "Option 3"
            ]
        },
        {
            "type": "date",
            "title": "Date Question",
            "description": "Date Question Description",
            "required": true
        }
    ]
}
```