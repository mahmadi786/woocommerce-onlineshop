import { __ } from "@wordpress/i18n";
import {
  BlockControls,
  InspectorControls,
  RichText,
} from "@wordpress/block-editor";
import {
  SelectControl,
  TextareaControl,
  Panel,
  PanelBody,
  PanelRow,
  ExternalLink
} from "@wordpress/components";

import "./editor.scss";

export const FIELD_SETTING = {
  NOTSHOW: "notshow",
  OPTIONAL: "optional",
  REQUIRED: "required",
};

const useCustomLists = () => {
  const [customLists, setCustomLists] = React.useState([]);
  const [loading, setLoading] = React.useState(false);
  const [hasLoaded, setHasLoaded] = React.useState(false);

  React.useEffect(() => {
    if (loading || hasLoaded) return;
    setLoading(true);
    jQuery
      .post(ce4wp_form_submit_data?.url, {
        action: "ce4wp_get_all_custom_lists",
        nonce: ce4wp_form_submit_data?.listNonce,
      })
      .done((response) => {
        setLoading(false);
        setHasLoaded(true);
        if (response?.data != null && response.data.length != undefined) {
          setCustomLists(response.data.map((list) => ({
            label: list.name,
            value: list.id,
          })))
        }
      });
  }, [loading, hasLoaded, customLists]);

  return {
    customLists,
    loading,
    hasLoaded,
  };
};

export default function Edit({
  attributes,
  setAttributes,
  className,
  clientId,
}) {
  const { blockId } = attributes;
  if (!blockId) {
    setAttributes({ blockId: clientId });
  }
  const { customLists } = useCustomLists()

  return (
    <div className={`wp-block-ce4wp-subscribe ${className ? className : ''}`}>
      <BlockControls key="setting">
        <InspectorControls key="setting">
          <Panel header="Settings">
            <PanelBody title="Contact Segmentation" initialOpen={true}>
              <PanelRow className="no-flex">
                <fieldset>
                  <i className="subTitle sub-header">
                    {__(
                      "Automatically assign a new contact to a list when they subscribe",
                      "ce4wp"
                    )}
                    <br />
                    <ExternalLink
                      onClick={() =>
                        ce4wpNavigateToDashboard(
                          this,
                          "fbcd9606-288a-4d82-be7c-449eaf5a3792",
                          { source: "ce4wp_form_menu" },
                          ce4wpDashboardStartCallback,
                          ce4wpDashboardFinishCallback
                        )
                      }
                    >
                      <span
                        id="ce4wp-manage-lists"
                        data-link_reference="836b20fc-9ff1-41b2-912b-a8646caf05a4"
                      >
                        {__("Manage your lists", "ce4wp")}
                      </span>
                    </ExternalLink>
                  </i>
                  <br />
                  <br />
                  <SelectControl
                    label="list"
                    value={attributes.customList}
                    options={[
                      {
                        label: __("Don't assign to a list", "cewp4"),
                        value: "",
                      },
                      ...customLists,
                    ]}
                    onChange={(customList) =>
                      setAttributes({
                        customList,
                      })
                    }
                  />
                </fieldset>
              </PanelRow>
            </PanelBody>
            <PanelBody title="On submission" initialOpen={true}>
              <PanelRow>
                <fieldset>
                  <TextareaControl
                    label="Message text"
                    value={attributes.onSubmission}
                    onChange={(onSubmission) => setAttributes({ onSubmission })}
                  />
                </fieldset>
              </PanelRow>
            </PanelBody>
            <PanelBody title="Disclaimer settings" initialOpen={true}>
              <PanelRow className="no-flex">
                <fieldset>
                  <SelectControl
                    label="Permission to mail"
                    value={attributes.emailPermission}
                    options={[
                      {
                        label: "message",
                        value: "message",
                      },
                      {
                        label: "checkbox",
                        value: "checkbox",
                      },
                    ]}
                    onChange={(emailPermission) =>
                      setAttributes({
                        ...attributes,
                        emailPermission: emailPermission,
                      })
                    }
                  />
                </fieldset>
              </PanelRow>
            </PanelBody>
            <PanelBody title="Field settings" initialOpen={true}>
              <PanelRow className="no-flex">
                <fieldset>
                  <SelectControl
                    label="First name field"
                    value={attributes.displayFirstName}
                    options={[
                      {
                        label: "Do not show",
                        value: FIELD_SETTING.NOTSHOW,
                      },
                      {
                        label: "Optional",
                        value: FIELD_SETTING.OPTIONAL,
                      },
                      {
                        label: "Required",
                        value: FIELD_SETTING.REQUIRED,
                      },
                    ]}
                    onChange={(displayFirstName) =>
                      setAttributes({
                        displayFirstName: displayFirstName,
                      })
                    }
                  />
                </fieldset>
              </PanelRow>
              <PanelRow className="no-flex">
                <fieldset>
                  <SelectControl
                    label="Last name field"
                    value={attributes.displayLastName}
                    options={[
                      {
                        label: "Do not show",
                        value: FIELD_SETTING.NOTSHOW,
                      },
                      {
                        label: "Optional",
                        value: FIELD_SETTING.OPTIONAL,
                      },
                      {
                        label: "Required",
                        value: FIELD_SETTING.REQUIRED,
                      },
                    ]}
                    onChange={(displayLastName) =>
                      setAttributes({
                        displayLastName: displayLastName,
                      })
                    }
                  />
                </fieldset>
              </PanelRow>
              <PanelRow className="no-flex">
                <fieldset>
                  <SelectControl
                    label="Telephone field"
                    value={attributes.displayTelephone}
                    options={[
                      {
                        label: "Do not show",
                        value: FIELD_SETTING.NOTSHOW,
                      },
                      {
                        label: "Optional",
                        value: FIELD_SETTING.OPTIONAL,
                      },
                      {
                        label: "Required",
                        value: FIELD_SETTING.REQUIRED,
                      },
                    ]}
                    onChange={(displayTelephone) =>
                      setAttributes({
                        displayTelephone: displayTelephone,
                      })
                    }
                  />
                </fieldset>
              </PanelRow>
            </PanelBody>
          </Panel>
        </InspectorControls>
      </BlockControls>
      <form name="contact-form">
        <RichText
          tagName="h2"
          onChange={(title) => {
            setAttributes({ title: title });
          }}
          value={attributes.title}
        />
        <RichText
          tagName="p"
          className="subTitle"
          onChange={(subTitle) => {
            setAttributes({ subTitle: subTitle });
          }}
          value={attributes.subTitle}
        />
        {attributes.displayFirstName !== FIELD_SETTING.NOTSHOW && (
          <div className="inputBlock">
            <RichText
              tagName="label"
              className="firstNameLabel"
              onChange={(firstNameLabel) => {
                setAttributes({ firstNameLabel: firstNameLabel });
              }}
              value={attributes.firstNameLabel}
            />
            {attributes.displayFirstName === FIELD_SETTING.REQUIRED && (
              <p
                className="required-text subTitle"
                style={{ color: "#ee0000" }}
              >
                *
              </p>
            )}
            <input name="first_name" type="text"></input>
          </div>
        )}
        {attributes.displayLastName !== FIELD_SETTING.NOTSHOW && (
          <div className="inputBlock">
            <RichText
              tagName="label"
              className="lastNameLabel"
              onChange={(lastNameLabel) => {
                setAttributes({ lastNameLabel: lastNameLabel });
              }}
              value={attributes.lastNameLabel}
            />
            {attributes.displayLastName === FIELD_SETTING.REQUIRED && (
              <p
                className="required-text subTitle"
                style={{ color: "#ee0000" }}
              >
                *
              </p>
            )}
            <input name="last_name" type="text"></input>
          </div>
        )}
        {attributes.displayTelephone !== FIELD_SETTING.NOTSHOW && (
          <div class="inputBlock">
            <RichText
              tagName="label"
              className="lastNameLabel"
              onChange={(telephoneLabel) => {
                setAttributes({ telephoneLabel: telephoneLabel });
              }}
              value={attributes.telephoneLabel}
            />
            {attributes.displayTelephone === FIELD_SETTING.REQUIRED && (
              <p
                className="required-text subTitle"
                style={{ color: "#ee0000" }}
              >
                *
              </p>
            )}
            <input name="telephone" type="text"></input>
          </div>
        )}
        <div className="inputBlock">
          <RichText
            tagName="label"
            className="emailLabel"
            onChange={(emailLabel) => {
              setAttributes({ emailLabel: emailLabel });
            }}
            value={attributes.emailLabel}
          />
          <p className="required-text subTitle" style={{ color: "#ee0000" }}>
            *
          </p>
          <input className="textwidget" name="email" type="text"></input>
        </div>
        {attributes.emailPermission == "message" && (
          <span className="disclaimer">
            {__(
              "By submitting your information, you are granting us permission to email you. You may unsubscribe at any time.",
              "cewp4"
            )}
          </span>
        )}
        {attributes.emailPermission == "checkbox" && (
          <div>
            <input
              type="checkbox"
              name={`consent_check_${clientId}`}
              id={`consent_check_${clientId}`}
            />
            <label htmlFor={`consent_check_${clientId}`} className="disclaimer">
              {__("Can we send you an email from time to time?", "cewp4")}
            </label>
          </div>
        )}
        <br />
        <button className="wp-block-button__link submit-button" type="button">
          {__("Subscribe", "cewp4")}
        </button>
      </form>
    </div>
  );
}
